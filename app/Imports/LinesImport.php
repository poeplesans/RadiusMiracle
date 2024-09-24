<?php

// app/Imports/LinesImport.php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;

class LinesImport implements ToArray
{
    public function array(array $array)
    {
        return $array;
    }
}

