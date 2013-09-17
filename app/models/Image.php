<?php
use PHPImageWorkshop\ImageWorkshop;

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

	public function manage(UploadedFile $file, $params)
	{
		$params = array_intersect_key($params, array_flip($this->params));
		$retina = (isset($params['make_retina']) && $params['make_retina'] == true);
		$name = strtolower($file->getClientOriginalName());
		$this->updateFile($file, $name, $retina);
		return $this->updateModel($params);
	}

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
		if ($this->validate()) {
			return [true, $this->save()];
		}
		return [false, $this->errors];
	}

	public function updateFile(UploadedFile $file, $name, $retina=false)
	{
		$name = strtolower($name);
		$this->name = ($retina) ? "$name@2x" : $name;
		$this->path = sprintf(Config::get('quill.upload_dir'), date('Y'));
		$file->move($this->path, $this->name);
		if ($retina) {
			$layer = $this->getLayer();
			$layer->resizeInPercent(50, null, true);
			$layer->save($this->path, $name);
		}
	}

	public function getFilePath()
	{
		return $this->path . '/' . $this->name;
	}

	public function getLayer()
	{
		return ImageWorkshop::initFromPath($this->getFilePath());
	}

	public function getSize()
	{
		$layer = $this->getLayer();
		return [$layer->getWidth(), $tlayer->getHeight()];
	}

	public function makeThumb($size=64)
	{
		$layer = $this->getLayer();
		$layer->resizeByLargestSizeInPixel($size, true);
		$layer->save($this->path . '/thumb', $this->name);
	}
}
