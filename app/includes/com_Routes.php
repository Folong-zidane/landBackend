<?php
<div>
    <h5>'les routes sont gerer dans ls fichier 
 web.php du repertoir route pour en creer on utilise la la bibiotheque "route"
 elle sutilise telle que:use Illuminate\Support\Facades\Route; on prcise qu on utilise la bibiotheque Route ensuiteon declare de la maniere suivante '</h5>

 Route::get('/path_fichier ', function () {
    return view('welcome');
});
les route peuvent aussi etre declarees de maniere dynamique comme suit:

Route ::get('/blog/{slug}-{id}', function()
{
    return 'bonjour tous le monde c est ftz';
}
);
autrement dit c'est la page qui a pour chemin '/blog/{slug}-{id} ou 'blog' peut etre une page deja existante et le '{ }'sont utilises pour indiquer que ce sont des parametres variantes c'est a dire on
peut avoir n'importe que texte a la place de 'slug' et de meme on peut avoir n'importe quel chiffe a la place de 'id'
un exemple simple d'url serait '/blog/mon-app-15'


</div>
?>