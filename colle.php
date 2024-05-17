<?php

function colle($x, $y, array $tab=[])
{
    if ($x <= 0 || $y <= 0) {
        return;
    }

    $grid = array_fill(0, $y, array_fill(0, $x, false));

    foreach ($tab as $position) {
        if (isset($position[0]) && isset($position[1])) {
            $grid[$position[1]][$position[0]] = true;
        }
    }

    for ($j = 0; $j < $y; $j++) {
        echo "+";
        for ($i = 0; $i < $x; $i++) {
            echo "---+";
        }
        echo "\n";

        echo "|";
        for ($i = 0; $i < $x; $i++) {
            if (isset($grid[$j][$i]) && $grid[$j][$i]) {
                echo " X |";
            } else {
                echo "   |";
            }
        }
        echo "\n";
    }

    echo "+";
    for ($i = 0; $i < $x; $i++) {
        echo "---+";
    }
    echo "\n";

    dialog($x, $y, $tab);
}

function dialog($x, $y, array &$tab)
{
    $command = readline("$> ");
    readline_add_history($command);
    $position = strpos($command, " ");
    $premierMot = substr($command, 0, $position);

    if ($premierMot === "query") {
        $restePhrase = substr($command, $position + 1);
        $numbers = array_map('intval', explode(', ', trim($restePhrase, "[]")));

        $found = false;
        foreach ($tab as $value) {
            if ($value === $numbers) {
                echo "full\n";
                $found = true;
                break;
            }
        }

        if (!$found) {
            echo "empty\n";
        }

    } elseif ($premierMot === "add") {
        $restePhrase = substr($command, $position + 1);
        $numbers = array_map('intval', explode(', ', trim($restePhrase, "[]")));

        $exists = false;
        foreach ($tab as $value) {
            if ($value === $numbers) {
                echo "A cross already exists at this location\n";
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            array_push($tab, $numbers);
        }
    } elseif ($premierMot === "remove") {
        $restePhrase = substr($command, $position + 1);
        $numbers = array_map('intval', explode(', ', trim($restePhrase, "[]")));

        $exists = false;
        foreach ($tab as $key => $value) {
            if ($value === $numbers) {
                unset($tab[$key]);
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            echo "No cross exists at this location\n";
        }

    } elseif ($command === "display") {
        colle($x, $y, $tab);
    }

    dialog($x, $y, $tab);
}
