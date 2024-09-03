<?php
$prenom='zidane';
$nom='Folong zidane';
echo "$prenom \n $nom \n";
$note1=10;
$note2=15;
$moyenne=($note1+$note2)/2;
echo $moyenne  ;
$boulen=true;
$notes=[10,15];
echo "\n";

echo $notes[1];

$structure = [
    'prenom' =>'zidane ',
    'nom' =>'tafoukeu folong',
    'note1' =>[12,14,16,18],
];
echo $structure['prenom'];
echo $structure['nom'];
echo $structure['note1'][1];
print_r($structure['note1']);
$note=12;
if ($note<$structure['note1'][2])
{
    echo "note votre note est inferieur au max";
    
}
else{
    echo "note votre note est superieur au max";
}
$heure=(int)readline("entrez une heure");
if ($heure>8 && $heure>0||$heure<18)                   // &&="ET";||="OU"
{
    echo "le magasin sera ouvert";
}
else{
    echo "le magasin n'est pas ferme";
}

$note=[];
$action=null;

while($action!="fin")
{
    $action=readline("entrez une note");
    if ($action=="fin")
    {
        break;
    }
    else
    {
        $note[]=(int)$action;
    }
}    
foreach($note as $notes)
{
    echo "$notes \n";
}



?>

merci