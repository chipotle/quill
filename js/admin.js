function makeSlug(slug) {
	slug = slug.toLowerCase().replace(/\ba\b/g, '').replace(/\bthe\b/g, '').trim();
	slug = slug.replace(/\s+/g, '-').replace('/_/g', '-').replace(/[^a-z0-9-]/g, '');
	slug = slug.replace(/-{2,}/g, '-');
	return slug;
}
