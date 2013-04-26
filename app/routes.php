<?php
use Michelf\Markdown;

Route::get('/', function()
{
    $text = <<<EOF
"Lorem ipsum dolor sit amet," consectetur adipiscing elit. Addidisti--ad extremum etiam indoctum fuisse. Iam in altera philosophiae parte. Respondeat totidem verbis. 

Scientiam pollicentur, quam non erat mirum sapientiae cupido patria esse cariorem. Quod autem principium officii quaerunt, melius quam Pyrrho; Illa videamus, quae a te de amicitia dicta sunt. "Nihil enim iam habes, quod ad corpus referas; Hanc ergo intuens debet 'institutum' illud quasi signum absolvere." Quid de Platone aut de Democrito loquar? 

*Idem iste, inquam,* de voluptate quid sentit? **Duo Reges:** constructio interrete. Quae animi affectio suum cuique tribuens atque hanc, quam dico. Cur igitur easdem res, inquam, Peripateticis dicentibus verbum nullum est, quod non intellegatur? Plane idem, inquit, et maxima quidem, qua fieri nulla maior potest. Minime vero istorum quidem, inquit. Ait enim se, si uratur, Quam hoc suave! dicturum.
EOF;
    $text = Markdown::defaultTransform($text);
    $text = SmartyPants::defaultTransform($text);
	return View::make('hello', ['text' => $text]);
});

// Administration functions
Route::group(['prefix' => 'sysop', 'before' => 'auth'], function()
{
    /**
     * TODO define what we need to be able to edit here...
     * - static pages
     * - user accounts
     * - author accounts/info
     * - stories
     * - issues
     * 
     * This should be relatively easy to manage from a UX standpoint: we
     * should be able to add author info from the story screen, publish an
     * individual issue and all the stories at once, get to author and story
     * info from issue screens (and add a story explicitly to that issue),
     * so on and so forth.
     */
});
