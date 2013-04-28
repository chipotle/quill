<?php
use Michelf\Markdown;

class Page extends Eloquent {

    /**
     * Database table used by model
     */
    protected $table = 'pages';

    protected $fillable = ['title', 'slug', 'body', 'head', 'is_visible'];

    public function getContent()
    {
        $body = Markdown::defaultTransform($this->body);
        $body = SmartyPants::defaultTransform($body);
        $title = SmartyPants::defaultTransform($this->title);
        $content = ['title' => $title, 'body' => $body, 'head' => $this->head];
        return $content;
    }
}
