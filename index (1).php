<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>fio</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

$fio = 'Иванов Иван Иванович';
$arr = getPartsFromFullname($fio);

// ==============================================

function getPartsFromFullname ($fio) {
    $indexes = ['surname', 'name', 'patronomyc']; // 0 1 2 indexses[0] = 'surname'
    $arr = array();
    for ($i=0; $i <= 2; $i++) { 
        $dop = explode(' ', $fio, 2 );
        $arr[$indexes[$i]] = array_shift($dop);
        if (count($dop)>0) {
           $fio = $dop[0];
        }
    }
    return $arr;
    //return $dop = explode(' ',$fio ); 0 1 2

    //https://php.ru/manual/function.explode.html
}

function getFullnameFromParts ($arr) {
    $fio = implode(' ', $arr);
    // $arr[0].' '.$arr[1].' '.$arr[2]
    return $fio;
}

function getShortName ($fio) {
    
    $divide = getPartsFromFullname ($fio);
    $short = $divide['name'] .' '.$divide['surname'][0].'.';
    return $short;
}

function endsWith(string $haystack, string $needle): bool
{
    $count = strlen($needle);
    
    if ($count === 0) {
        return true;
    }
    
    return (substr($haystack, -$count) === $needle);
}

function getGenderFromName($fio) {
    
    if (gettype($fio) == 'string') {
        $divide = getPartsFromFullname ($fio);
    }
    else {$divide = $fio;}

    $gender = 0;

    if (endsWith($divide['patronomyc'], 'вна')) {
        $gender--;
    }
    elseif (endsWith($divide['patronomyc'], 'ич')) { 
        $gender++; }

    if (endsWith($divide['name'], 'а')) {
        $gender--;
    }
    elseif (endsWith($divide['name'], 'й') || endsWith($divide['name'], 'н')) { $gender++; }

    if (endsWith($divide['surname'], 'ва')) {
        $gender--;
    }
    elseif (endsWith($divide['surname'], 'в')) { $gender++; }

    if ($gender > 0) {
        return 'man';
    }   
    elseif ($gender < 0) {
        return 'woman';
    }
    else{
        return 'undefined';
    }
}

function f($arr) {
    for ($i=0; $i <= count($arr)-1; $i++) { 
        print_r($arr[$i]['fullname']);
        echo '   ';
        print_r(getGenderFromName($arr[$i]['fullname']));
        echo '<br>';
    }
}


function  getGenderDescription($arr) {
    $man = 0;
    $woman = 0;
    $undf = 0;
    for ($i=0; $i <= count($arr)-1; $i++) {
        if (getGenderFromName($arr[$i]['fullname']) == 'man') {
            $man++;
        }
        elseif (getGenderFromName($arr[$i]['fullname']) =='woman') {
            $woman++;
        }
        else {
            $undf++;
        }
     }  
     echo 'woman: '; print_r(round(100*$woman/count($arr), 2));
     echo '<br>';
     echo 'man: ';print_r(round(100*$man/count($arr), 2));
     echo '<br>';
     echo 'underfined: '; print_r(round(100*$undf/count($arr), 2));
}

function getPerfectPartner($f, $i, $o, $arr){
    $f = mb_strtoupper(mb_substr($f, 0 , 1)) . mb_strtolower(mb_substr($f, 1));
    $i = mb_strtoupper(mb_substr($i, 0 , 1)) . mb_strtolower(mb_substr($i, 1));
    $o = mb_strtoupper(mb_substr($o, 0 , 1)) . mb_strtolower(mb_substr($o, 1));
    $fio = $f. ' '. $i.' '.$o;

    do {
        $n = rand(0, count($arr)-1);
        
    } while ((getGenderFromName($arr[$n]['fullname']) == getGenderFromName($fio)) || (getGenderFromName($arr[$n]['fullname']) == 'undefined'));
    
    echo('<br>' . $fio. ' + '. $arr[$n]['fullname']);

    echo('Идеально на '.  round(rand(5000, 10000)/100, 2) . '%');
}

?>

<a href="https://apps.skillfactory.ru/learning/course/course-v1:SkillFactory+PHPPRO+2022/block-v1:SkillFactory+PHPPRO+2022+type@sequential+block@8c64b7e02b224744841d726a78481384/block-v1:SkillFactory+PHPPRO+2022+type@vertical+block@20ebb0f4f7b54926bc1a6eb824de7287">TASK</a>
<p><?php print_r($arr)  ?></p>
<p>string -> array: <?php print_r(getPartsFromFullname($fio))  ?></p>
<p>array -> string: <?php print_r(getFullnameFromParts($arr))  ?></p>

<p>short name: <?php print_r(getShortName('Ivanov Иван Ивановвна'))  ?></p>
<p>gender: <?php print_r(getGenderFromName('Иванова Маша Ивановна'))  ?></p>
<?php f($example_persons_array); 
getGenderDescription($example_persons_array);
getPerfectPartner( 'пупкин', 'петр', 'ваСильеич', $example_persons_array)
?>
</body>
</html>