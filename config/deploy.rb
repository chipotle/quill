# Capistrano Laravel 4 Deployment Tasks
# Watts Martin (layotl at gmail com)
# https://gist.github.com/chipotle/5506641
# updated 30-Jul-2013

# Assumptions:
#
#   - You are using a .gitignore similar to Laravel's default, so your
#     vendor directory and composer(.phar) are *not* under version control
#   - Composer is installed as an executable at /usr/local/bin/composer
#
# If you don't have Composer installed globally, modify the appropriate task
# (:composer_install). Or just install Composer globally!

set :application, "Claw and Quill"
set :repository,  "git@github.com:chipotle/quill.git"

set :scm, :git
set :scm_username, "chipotle"

role :web, "clawandquill.net"
role :app, "clawandquill.net"
role :db,  "clawandquill.net", :primary => true

set :deploy_to, "/opt/nginx/sites/quill"
set :deploy_via, :remote_cache

set :use_sudo, false
set :ssh_options, {:forward_agent => true}
set :copy_exclude, [".git", ".gitignore", ".tags", ".tags_sorted_by_file"]
set :keep_releases, 4

# Nginx requires the php_fpm:reload task; other servers may not
after :deploy, "php_fpm:reload"

namespace :deploy do

  task :update do
    transaction do
      update_code
      copy_config
      composer_install
      link_shared
      fix_permissions
    end
  end

  task :finalize_update do
    transaction do
      run "chmod -R g+w #{releases_path}/#{release_name}"
      symlink
    end
  end

  task :symlink do
    transaction do
      run "ln -nfs #{current_release} #{deploy_to}/#{current_dir}"
    end
  end

  desc "Link Laravel shared directories."
  task :link_shared do
    transaction do
      run "ln -nfs #{shared_path}/system #{current_release}/public/system"
    end
  end

  desc "Run migrations in Artisan."
  task :migrate do
    run "php #{current_release}/artisan migrate"
  end

  desc "Set Laravel storage directory world-writable."
  task :fix_permissions do
    transaction do
      run "chmod -R a+w #{current_release}/app/storage"
    end
  end

  desc "Install dependencies with Composer"
  task :composer_install do
    transaction do
      run "cd #{current_release};/usr/local/bin/composer install --no-dev"
    end
  end

  desc "Copy server-specific configuration files."
  task :copy_config do
    transaction do
      run "cp #{shared_path}/config/* #{current_release}/app/config/"
    end
  end

end

# This command is tested on Arch Linux; other distributions/OSes may need a
# different configuration (or may not require this at all).
namespace :php_fpm do
  desc "Reload PHP-FPM (requires sudo access to systemctl)."
  task :reload, :roles => :app do
    run "sudo /usr/bin/systemctl reload-or-restart php-fpm"
  end
end

# Database dump task adapted from https://gist.github.com/rgo/318312
namespace :db do
  task :backup_name, :roles => :db do
    now = Time.now
    run "mkdir -p #{shared_path}/db_backups"
    backup_time = [now.year, now.month, now.day, now.hour, now.min].join('-')
    set :backup_file, "#{shared_path}/db_backups/#{database}-#{backup_time}.sql"
  end

  desc "Backup MySQL or PostgreSQL database to shared_path/db_backups"
  task :dump, :roles => :db do
    run("php -r '$db=include\"#{shared_path}/config/database.php\";echo json_encode($db,JSON_UNESCAPED_SLASHES);'") { |channel, stream, data| @environment_info = YAML.load(data) }
    default = @environment_info['default']
    connection = @environment_info['connections'][default]
    dbuser = connection['username']
    dbpass = connection['password']
    database = connection['database']
    dbhost = connection['host']
    set :database, database
    backup_name
    if connection['driver'] == 'mysql'
      run "mysqldump --add-drop-table -u #{dbuser} -h #{dbhost} -p #{database} | bzip2 -c > #{backup_file}.bz2" do |ch, stream, out |
        ch.send_data "#{dbpass}\n" if out=~ /^Enter password:/
      end
    else
      run "pg_dump -W -c -U #{dbuser} -h #{dbhost} #{database} | bzip2 -c > #{backup_file}.bz2" do |ch, stream, out |
        ch.send_data "#{dbpass}\n" if out=~ /^Password:/
      end
    end
  end

  desc "Sync production database to your local workstation"
  task :clone_to_local, :roles => :db, :only => {:primary => true} do
    dump
    get "#{backup_file}.bz2", "/tmp/#{application}.sql.bz2"
    data = `php -r '$db=include"app/config/database.php";echo json_encode($db,JSON_UNESCAPED_SLASHES);'`
    development_info = YAML.load(data)
    default = development_info['default']
    connection = development_info['connections'][default]
    dbuser = connection['username']
    dbpass = connection['password']
    database = connection['database']
    dbhost = connection['host']
    if connection['driver'] == 'mysql'
      run_str = "bzcat '/tmp/#{application}.sql.bz2' | mysql -u #{dbuser} --password='#{dbpass}' -h #{dbhost} #{database}"
    else
      run_str = "PGPASSWORD=#{dbpass} bzcat '/tmp/#{application}.sql.bz2' | psql -U #{dbuser} -h #{dbhost} #{database}"
    end
    %x!#{run_str}!
  end

end
