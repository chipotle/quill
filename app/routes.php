<?php
use Michelf\Markdown;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

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
