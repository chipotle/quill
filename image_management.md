Image management --

Basically, we need to be able to get the images in as three things:

* Covers for issues
* Title images for stories
* Linked images within stories

In the first two cases the image models are linked back to a story/issue; in the third case, the model isn't.

We need to be able to create thumbnails.

In addition to managing Images directly with a controller, we really need to be able to do Ajax sort of things --

From the story editor, we should be able to

* pull up a list of images
	* with thumbnails
	* maybe just for that story *or* unassigned
* Copy the Markdown image link
	* for the image as a whole, or the thumbnail?
* Upload a new image and get its link immediately

And, when editing the metadata for a story *or* issue, we should be able to

* add an existing image as a cover
* upload a new image

Also, the upload system needs to be able to

* generate thumbnails (just on request?)
* handle "Retina" 2x images by shrinking uploaded ones down (maybe?)

The non-Ajax Image management page needs to be able to do all things, too.
