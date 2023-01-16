
<?php
require_once ('./pokemonClass.php');

$pokemon = [];
$arrayTipos = [];
$arrayFinal = [];
$arrayDobleTipo = [];
$pokeInfo = [];
$arrayObjetosPokemon = [];
$array= [];
$arrayAtaques = [];
$pokemonJSON = file_get_contents("https://pokeapi.co/api/v2/pokemon?limit=900");
$pokemonDecoded = json_decode($pokemonJSON,true,512,JSON_UNESCAPED_UNICODE);

//Creacion de array de arrays de pokemons con nomnbre y url de la api
$arrayPokes = [];
$pokemons = $pokemonDecoded["results"];
for ($i=0; $i < 4; $i++) 
{ 
    array_push($arrayPokes,$pokemons[rand(1,900)]);
}

//Asignacion de valores de propiedades de los cada pokemon del arrayPokes
foreach ($arrayPokes as $key => $value) 
{
    $i += 1;
    $pokeInfoRaw = file_get_contents($value["url"]);
    $infoJSON = json_decode($pokeInfoRaw,true,512,JSON_UNESCAPED_UNICODE);
    $pokeInfo[$i] = $infoJSON;
}

//Devuelve un array de tipos de cada pokemon
function getTipos($pokemon)
{
    global $array;
    $arrayTipos = [];
    foreach ($pokemon as $llave => $arraySlotType) 
    {           
        if($llave == "types" && is_array($arraySlotType))
        {   
            foreach ($arraySlotType as $llave2 ) 
            {
                array_push($arrayTipos,$llave2["type"]["name"]);            
            }           
        }                
    }
    return $arrayTipos;
}

function getNombrePoke($pokemon)
{
    return $pokemon["name"];
}

//Recoge la imagen del pokemon de la API
function getPicture($pokemon)
{
    foreach ($pokemon as $key => $value) 
    {
        if($key == "sprites" && is_array($value))
        {
            foreach ($value as $str => $foto ) 
            {
                if ($str == "front_default")
                {
                    return $foto;
                }
            }
        }
    }
}

function setGradient($arrayColores)
{
    if (count($arrayColores) > 1)
    {
        $gradiente = ("style = ' background: linear-gradient($arrayColores[0],$arrayColores[1]);'");
        echo($gradiente);
    }
    else
    {
        $color = ("style = ' background-color : $arrayColores[0]'");
        echo($color);
    }
 
}

//Genera una array de 1 o 2 carcteres dependiendo del numero de tipos del pokemon
function colorFondo($tipo)
{
    $arrayColores = [];
    for ($p=0; $p < count($tipo) ; $p++) 
    { 
        switch ($tipo[$p]) 
        {
            case 'normal':
                $color = '#A8A77A';
                array_push($arrayColores,$color);
                break;
            case 'fire':
                $color = '#EE8130';
                array_push($arrayColores,$color);
                break;
            case 'water':
                $color = '#6390F0';
                array_push($arrayColores,$color);
                break;
            case 'grass':
                $color = '#7AC74C';
                array_push($arrayColores,$color);
                break;
            case 'electric':
                $color = '#F7D02C';
                array_push($arrayColores,$color);
                break;
            case 'ice':
                $color = '#96D9D6';
                array_push($arrayColores,$color);
                break;
            case 'fighting':
                $color = '#C22E28';
                array_push($arrayColores,$color);
                break;
            case 'poison':
                $color = '#A33EA1';
                array_push($arrayColores,$color);
                break;
            case 'ground':
                $color ='#E2BF65';
                array_push($arrayColores,$color);
                break;
            case 'flying':
                $color = '#A98FF3';
                array_push($arrayColores,$color);
                break;
            case 'bug':
                $color = '#A6B91A';
                array_push($arrayColores,$color);
                break;
            case 'rock':
                $color = '#B6A136';
                array_push($arrayColores,$color);
                break;
            case 'ghost':
                $color = '#735797';
                array_push($arrayColores,$color);
                break;
            case 'dark':
                $color = '#705746';
                array_push($arrayColores,$color);
                break;
            case 'dragon':
                $color = '#6F35FC';
                array_push($arrayColores,$color);
                break;
            case 'steel':
                $color = '#B7B7CE';
                array_push($arrayColores,$color);
                break;
            case 'fairy':
                $color = '#D685AD';
                array_push($arrayColores,$color);
                break;      
            case 'psychic':
                $color = '#F95587';
                array_push($arrayColores,$color);
                break;
        }
    
    }
    return $arrayColores;
   
}

//Devuelve un array de ataques
function getAtaques($pokemon)
{
    $n = 0;
    global $arrayAtaques;
    $arrayAtaques = [];
    foreach ($pokemon as $llave => $arraySlotType) 
    {           
        if($llave == "abilities" && is_array($arraySlotType))
        {       
            foreach ($arraySlotType as $llave2 ) 
            {                  
                array_push($arrayAtaques,$llave2["ability"]);     
                $n += 1;                             
            }
            
        }                
    }
    return ($arrayAtaques);
}

//Genera codigo html a partir del array de ataques introduciendolo en el tooltip correspondiente
function setAtaques($ataques)
{
    foreach ($ataques as $key ) 
    {
            echo("<ul>");
            echo("<div class = 'hover-text'>".ucfirst($key['name']));
            $ataque = file_get_contents($key["url"]);
            $ataqueDecoded = json_decode($ataque,true,512,JSON_UNESCAPED_UNICODE);

            foreach ($ataqueDecoded['flavor_text_entries'] as $key => $value) 
            {
                if ($value['language']['name'] =='en')
                {
                    $parraph = $value['flavor_text'];
                }
            }
          
            echo("<span class = 'tooltip-text'>"
            .
            $parraph
            ."</span>");
            echo("</div>");
            echo("</ul>");
        
    }
}

//Imagenes de los tipos de cada pokemon
function setSVG($tipos)
{  
    //Autoincremento para diferenciar la id
    $a = 0;
    foreach ($tipos as $key ) 
    {
        switch ($key) 
        {
            case 'normal':
                echo("<img id = $a class = 'imagenes' src ='.\icons/normal.svg'>");
                $a += 1;
            break;
            case 'psychic':
                echo("<img id = $a class = 'imagenes' src ='.\icons/psychic.svg'>");
                $a += 1;
            break;
            case 'fire':
                echo("<img id = $a class = 'imagenes' src ='.\icons/fire.svg'>");
                $a += 1;
            break;
            case 'water':
                echo("<img id = $a class = 'imagenes' src ='.\icons\water.svg'>");
                $a += 1;
            break;
            case 'grass':
                echo("<img id = $a class = 'imagenes' src ='.\icons\grass.svg'>");
                $a += 1;
            break;
            case 'electric':
                echo("<img id = $a class = 'imagenes' src ='.\icons/electric.svg'>");
                $a += 1;
            break;
            case 'ice':
                echo("<img id = $a class = 'imagenes' src ='.\icons\ice.svg'>");
                $a += 1;
            break;
            case 'fighting':
                echo("<img id = $a class = 'imagenes' src ='.\icons/fighting.svg'>");
                $a += 1;
            break;
            case 'poison':
                echo("<img id = $a class = 'imagenes' src ='.\icons\poison.svg'>");
                $a += 1;
                break;
            case 'ground':
                echo("<img id = $a class = 'imagenes' src ='.\icons\ground.svg'>");
                $a += 1;
            break;
            case 'flying':
                echo("<img id = $a class = 'imagenes' src ='.\icons/flying.svg'>");
                $a += 1;
            break;
            case 'bug':
                echo("<img id = $a class = 'imagenes' src ='.\icons\bug.svg'>");
                $a += 1;
            break;
            case 'rock':
                echo("<img id = $a class = 'imagenes' src ='.\icons/rock.svg'>");
                $a += 1;
            break;
            case 'ghost':
                echo("<img id = $a class = 'imagenes' src ='.\icons\ghost.svg'>");
                $a += 1;
            break;
            case 'dark':
                echo("<img id = $a class = 'imagenes' src ='.\icons\dark.svg'>");
                $a += 1;
            break;
            case 'dragon':
                echo("<img id = $a class = 'imagenes' src ='.\icons\dragon.svg'>");
                $a += 1;
            break;
            case 'steel':
                echo("<img id = $a class = 'imagenes' src ='.\icons\steel.svg'>");
                $a += 1;
            break;
            case 'fairy':
                echo("<img id = $a class = 'imagenes' src ='.\icons/fairy.svg'>");
                $a += 1;
            break;    
        } 
    }      
}

function getVida($pokemon)
{
    foreach ($pokemon as $key => $value) 
    {
        if ($key == 'stats')
        {  
            $vida = $value[0]['base_stat'];   
            return $vida;
        }
    }
}

//Funcion que genera todos los objetos de N pokemons y los pushea a $arrayObjetosPkemon
function generarObjetosPokemon()
{
    global $arrayObjetosPokemon;
    global $pokeInfo;
    $i = 0;
    foreach ($pokeInfo as $pokemon ) 
    {
        $pokemon = new Pokemon(getNombrePoke($pokemon),getPicture($pokemon),getTipos($pokemon),getAtaques($pokemon),getVida($pokemon));
        $i ++;
        array_push($arrayObjetosPokemon,$pokemon); 
    }
}

generarObjetosPokemon();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" defer integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <div class = "row">
<?php foreach ($arrayObjetosPokemon as $poke) 
    { ?>
        <div id="pokeCard" class = "col-xl-3 col-lg-4 col-md-6 col-sm-12" <?php setGradient((colorFondo($poke->printTipos())))?>>
            <div id = 'header'>
                <span class ="nombre"><?php echo(strtoupper($poke->printNombre()));?></span> 
                <span class = 'vida'><?php echo($poke->printVida())?>♥</span>
            </div>       
            <div class ="foto"><img class = 'fotoPoke' src="<?php echo($poke->printFoto());?>"></div>  
            <div class ="ataques"><?php setAtaques($poke->printHabilidades())?></div>  
            <div class ="tipo"><?php setSVG($poke->printTipos())?></div>
        </div>
    
<?php } ?>
</div>
</div>
</body>
</html>