<?php


namespace App;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;


class ImageOptimizer
{
    private const MAX_WIDTH = 200;
    private const MAX_SCREENSHOTS_WIDTH = 350;
    private const MAX_HEIGHT = 150;
    private const MAX_SCREENSHOTS_HEIGHT = 250;

    private $imagine;

    public function __construct()
    {
        $this->imagine = new Imagine();
    }

    public function resize(string $filename, string $miniFileName, string $type): void
    {
        list($iwitdh, $iheiht) = getimagesize($filename);
        $ratio = $iwitdh / $iheiht;
        if ($type == 'cover') {
            $witdh = self::MAX_WIDTH;
            $height = self::MAX_HEIGHT;
        } else {
            $witdh = self::MAX_SCREENSHOTS_WIDTH;
            $height = self::MAX_SCREENSHOTS_HEIGHT;
        }
        if ($witdh / $height > $ratio) {
            $witdh = $height * $ratio;
        } else {
            $height = $witdh / $ratio;
        }

        $photo = $this->imagine->open($filename);
        $photo->resize(new Box($witdh, $height))->save($miniFileName);
    }


}