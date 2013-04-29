set :application, "Claw and Quill"
set :repository,  "git@github.com:chipotle/quill.git"

set :scm, :git
set :scm_username, "chipotle"

role :web, "test.clawandquill.net"
role :app, "test.clawandquill.net"
role :db,  "test.clawandquill.net", :primary => true

set :deploy_to, "/opt/nginx/sites/quill-test"
set :deploy_via, :remote_cache

set :use_sudo, false
set :ssh_options, {:forward_agent => true}
set :copy_exclude, [".git", ".gitignore", ".tags", ".tags_sorted_by_file"]
set :keep_releases, 5

# Laravel deployment
namespace :deploy do

  task :update do
    transaction do
      update_code
      symlink
      copy_config
      composer_install
      laravel_migrate
    end
  end

  task :finalize_update do
    transaction do
      run "chmod -R g+w #{releases_path}/#{release_name}"
    end
  end

  task :symlink do
    transaction do
      run "ln -nfs #{current_release} #{deploy_to}/#{current_dir}"
    end
  end

  task :laravel_migrate do
    transaction do
      run "php  #{deploy_to}/#{current_dir}/artisan migrate"
    end
  end

  task :laravel_rollback do
    run "php  #{deploy_to}/#{current_dir}/artisan migrate:rollback"
  end

  task :restart do
    transaction do
      # set writable storage dir
      run "mydir=\"#{deploy_to}/#{current_dir}/app/storage\";if [ -d $mydir/cache ]; then chmod -R 777 $mydir/cache; rm -f $mydir/cache/*; fi"
      run "mydir=\"#{deploy_to}/#{current_dir}/app/storage\";if [ -d $mydir/database ]; then chmod -R 777 $mydir/database; fi"
      run "mydir=\"#{deploy_to}/#{current_dir}/app/storage\";if [ -d $mydir/logs ]; then chmod -R 777 $mydir/logs; fi"
      run "mydir=\"#{deploy_to}/#{current_dir}/app/storage\";if [ -d $mydir/sessions ]; then chmod -R 777 $mydir/sessions; fi"
      run "mydir=\"#{deploy_to}/#{current_dir}/app/storage\";if [ -d $mydir/views ]; then chmod -R 777 $mydir/views; rm -f $mydir/views/*; fi"
      run "mydir=\"#{deploy_to}/#{current_dir}/app/storage\";if [ -d $mydir/work ]; then chmod -R 777 $mydir/work; fi"
    end
  end

  task :composer_install do
    transaction do
      run "cd #{deploy_to}/#{current_dir};/usr/local/bin/composer install"
    end
  end

  task :copy_config do
    transaction do
      run "cp #{shared_path}/config/* #{deploy_to}/#{current_dir}/app/config/"
    end
  end


end



after "deploy:rollback", "deploy:laravel_rollback"
