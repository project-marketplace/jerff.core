<?php

namespace Project\Core;

use CFile;

class Image {

    const WARERMARK = '/images/warermark.png';

    static private function isWatermark($ID) {
        return true;
    }

    static public function catalog($ID, $width, $height) {
        if (self::isWatermark($ID)) {
            $path = cFile::GetPath($ID);
            $newPath = $_SERVER['DOCUMENT_ROOT'] . ($img = str_replace('/upload/', '/upload/resize_cache/warermark/', $path));
            CFile::ResizeImageFile(
                    $_SERVER['DOCUMENT_ROOT'] . $path, $newPath, array('width' => $width, 'height' => $height), BX_RESIZE_IMAGE_PROPORTIONAL, array(
                "name" => "watermark",
                "position" => "center",
                "size" => "resize",
                'coefficient' => 0.8,
                "file" => $_SERVER['DOCUMENT_ROOT'] . self::WARERMARK
                    )
            );
            return $img;
        } else {
            return self::resize($ID, $width, $height);
        }
    }

    static public function resize($ID, $width, $height) {
        return CFile::ResizeImageGet($ID, array('width' => $width, 'height' => $height), BX_RESIZE_IMAGE_PROPORTIONAL, false)['src'];
    }

}
