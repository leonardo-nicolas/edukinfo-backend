<?php

namespace EdukInfo\Models;

class ImagemCarrossel
{
    /*

        1 = GIF	5 = PSD	9 = JPC	13 = SWC
        2 = JPG	6 = BMP	10 = JP2	14 = IFF
        3 = PNG	7 = TIFF(intel byte order)	11 = JPX	15 = WBMP
        4 = SWF	8 = TIFF(motorola byte order)	12 = JB2	16 = XBM
     */
    public function __construct(
        public readonly string          $src,
        public readonly string          $alt,
        public readonly string|int|null $number,
        public readonly string|int|null $height
    )
    {
        list($width,$height, $type,$attr) = getimagesize('');
    }

}