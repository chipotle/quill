<?php
use PHPImageWorkshop\ImageWorkshop,
	Symfony\Component\HttpFoundation\File\UploadedFile;

class Image extends BaseModel {

	protected $table = 'images';

	protected $params = ['caption', 'alt_text', 'make_thumb', 'make_retina'];

	public static $rules = [
	];

	/**
	 * Image belongsTo (table) polymorphic
	 */
	public function imageable()
	{
		return $this->morphTo();
	}

	/**
	 * Updates the image model fields from a parameter array
	 *
	 * @param array $params values for model fields
	 * @return boolean $retina true if make_retina was set to true
	 */
	public function updateModel($params)
	{
		$params = array_intersect_key($params, array_flip($this->params));
		$retina = (isset($params['make_retina']) && $params['make_retina'] == true);
		foreach ($params as $param => $value) {
			switch ($param) {
				case 'make_thumb':
					$this->makeThumb();
					break;

				case 'make_retina':
					break;

				default:
					$this->$param = $value;
					break;
			}
		}
		return $retina;
	}

	/**
	 * Update the image file associated with this model.
	 *
	 * @param UploadedFile $file file uploaded
	 * @param boolean $retina true to create retina image
	 */
	public function updateFile(UploadedFile $file, $retina=false)
	{
		if (! $file->isValid()) {
			$err = $file->getError();
			throw \RuntimeException("File $name invalid ($err)");
		}
		$this->name = strtolower($file->getClientOriginalName());
		$name = $this->getName($retina);
		$this->path = $this->path ?: sprintf(Config::get('quill.upload_dir'), date('Y'));
		if (! is_dir($this->path)) {
			if (mkdir($this->path, 0777, true) === false) {
				throw \RuntimeException("Directory {$this->path} could not be created");
			}
		}
		// UploadedFile::move() fails without a useful error message, so we're bailing and using PHP's native function instead
		// $file->move($this->path, $name);
		$ok = move_uploaded_file($_FILES['file']['tmp_name'], $this->path . $name);
		if ($ok && $retina) {
			$layer = $this->getLayer(true);
			$layer->resizeInPercent(50, null, true);
			$iq = (substr($this->name, -3) == 'jpg') ? 75 : 100;
			$layer->save($this->path, $this->name, true, null, $iq);
		}
		return $ok;
	}

	public function getName($retina=false)
	{
		if ($retina) {
			$path_parts = pathinfo($this->name);
			return $path_parts['filename'] . '@2x.' . $path_parts['extension'];
		}
		return $this->name;
	}

	/**
	 * Get the file system path for the associated image
	 *
	 * @param boolean $retina true to return path to retina imageable
	 */
	public function getFilePath($retina=false)
	{
		return $this->path . $this->getName($retina);
	}

	public function getFileURL($retina=false)
	{
		$public_pos = strpos($this->path, '/public');
		return substr($this->path, $public_pos + 7) . $this->getName($retina);
	}

	public function getLayer($retina=false)
	{
		return ImageWorkshop::initFromPath($this->getFilePath($retina));
	}

	public function getSize()
	{
		$layer = $this->getLayer();
		return [$layer->getWidth(), $tlayer->getHeight()];
	}

	public function makeThumb($size=64)
	{
		$layer = $this->getLayer();
		$layer->resizeByLargestSideInPixel($size, true);
		$layer->save($this->path . '/thumb', $this->name);
	}
}
