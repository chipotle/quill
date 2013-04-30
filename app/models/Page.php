<?php
use Michelf\Markdown, Chipotle\Smartypants;

class Page extends Eloquent {

    /**
     * Database table used by model
     */
    protected $table = 'pages';

    protected $fillable = ['title', 'slug', 'body', 'head', 'is_visible'];

    public function getContent()
    {
        $content = Cache::rememberForever("page-{$this->id}", function() {
            $body = Markdown::defaultTransform($this->body);
            $body = Smartypants::defaultTransform($body);
            $title = Smartypants::defaultTransform($this->title);
            return ['title' => $title, 'body' => $body,
                    'head' => $this->head];
        });
        return $content;
    }
}
