<?php

namespace Project\Core;

use CFile;

class Image {

    static public function resize($ID, $width, $height) {
        return CFile::ResizeImageGet($ID, array('width' => $width, 'height' => $height), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
    }

}
