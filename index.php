<?php
function fitness($individual)
{
    $conflicts = 0;
    for ($i = 0; $i < count($individual); $i++) {
        for ($j = $i + 1; $j < count($individual); $j++) {
            if ($individual[$i] == $individual[$j] || abs($individual[$i] - $individual[$j]) == $j - $i) {
                $conflicts++;
            }
        }
    }
    return $conflicts;
}

function generate_individual()
{
    $individual = array();
    for ($i = 0; $i < 8; $i++) {
        $individual[] = rand(0, 7);
    }
    return $individual;
}

function mutate($individual)
{
    $index = rand(0, 7);
    $individual[$index] = rand(0, 7);
    return $individual;
}

$population = array();
for ($i = 0; $i < 100; $i++) {
    $population[] = generate_individual();
}
$k = 0;

while (true) {
    $k++;
    if ($k > 100) {
        echo "<a href='queen_problem2.php'> again </a>";
        exit();
    }
    $fitnesses = array();
    foreach ($population as $individual) {
        $fitnesses[] = fitness($individual);
    }

    $min_fitness = min($fitnesses);
    if ($min_fitness == 0) {
        break;
    }

    $parents = array();
    for ($i = 0; $i < 20; $i++) {
        $parents[] = $population[array_search(min($fitnesses), $fitnesses)];
        unset($fitnesses[array_search(min($fitnesses), $fitnesses)]);
    }

    $offsprings = array();
    for ($i = 0; $i < 80; $i++) {

        $parent1 = $parents[rand(0, 19)];
        $parent2 = $parents[rand(0, 19)];
        $offspring = array();

        $offspring = array_merge(array_slice($parent1, 0, 4), array_slice($parent2, 4, 4));

        $offsprings[] = mutate($offspring);
    }

    foreach ($offsprings as $offspring) {
        $population[] = $offspring;
    }

}

$a = $population[array_search(min($fitnesses), $fitnesses)];


header("Content-Type: image/png");
$image_chess = imagecreatefromjpeg('chess.jpeg');
$image_chess2 = imagecreatefrompng('image.png');

for ($i = 0; $i < 8; $i++) {
    imagecopymerge($image_chess, $image_chess2, $a[$i] * 100, $i * 100, 0, 0, 100, 100, 100);
}
imagepng($image_chess);
