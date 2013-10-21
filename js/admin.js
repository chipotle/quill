function makeSlug(slug) {
	slug = slug.toLowerCase().replace(/\ba\b/g, '').replace(/\bthe\b/g, '').trim();
	slug = slug.replace(/\s+/g, '-').replace('/_/g', '-').replace(/[^a-z0-9-]/g, '');
	slug = slug.replace(/-{2,}/g, '-');
	return slug;
}

$(function(){
  $('.delete').on('click', function(event) {
    var href = $(this).attr('href');
    var name = $(this).data('name');
    if (confirm('Delete "' + name + '"?')) {
      $.ajax({
        url: href,
        type: 'delete',
        dataType: 'json',
        success: function(response) {
          if (response.alert) {
            alert(response.alert);
          }
          if (response.reload) {
            window.location.reload(true);
          }
          else if (response.redirect) {
            window.location.replace(response.redirect);
          }
        }
      });
    }
    return false;
  });
});
