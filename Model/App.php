<?php

    namespace Model;

    class App
    {
        public $data;

        const PATH = '/tmp/';
        public function __construct()
        {

        }

        public function downloadData($dataParams)
        {
            if ($url = $dataParams['url']) {
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $result = curl_exec($curl);
                $document = @\phpQuery::newDocument($result);
                $images = $document->find('img');
                $domain = parse_url('https://' . str_replace(array('https://', 'http://'), '', $url), PHP_URL_HOST) . '/';
                $resultImages = [];
                foreach ($images as $img) {
                    $pq = pq($img);
                    $src = $pq->attr('src'); // only with <img>, <picture> tag in next time

                    if ($src && str_starts_with($src, 'data:image')) {
                        continue; // in next time
                    }
                    if (!str_starts_with($src, 'http')) {
                        $src = $domain . $src; // try to add domain
                        $src = preg_replace('|([/]+)|s', '/', $src); // removing trailing slashes
                        $src = 'https://' . $src;
                    }

                    try {
                        $downloadedImage = file_get_contents($src);
                        $path = parse_url($src, PHP_URL_PATH);
                        $filename = basename($path);
                        $image = new \Imagick();
                        $image->readImageBlob($downloadedImage);
                        $sizes = $image->getImageGeometry();
                        if ($dataParams['minWidth'] && $sizes['width'] < $dataParams['minWidth'] || $dataParams['minHeight'] && $sizes['height'] < $dataParams['minHeight']) {
                            continue;
                        }
                        $image->cropThumbnailImage(200, 200);
                        $draw = new \ImagickDraw();
                        $draw->setFontSize( 20 );
                        $image->annotateImage($draw, 10, 45, 0, $dataParams['text']);
                        $deniedSymbols = '\/:*?"<>|+%!@';
                        $filename = preg_replace("/[${deniedSymbols}]/", '', $filename);
                        $image->writeImage(getcwd() .self::PATH . random_int(1, 999). $filename);

                        $image->destroy();
                    } catch (\Exception $e) {
                        //log it
                        continue;
                    }
                }

            }
        }
        public function getData()
        {
            $result = [];
            $f = scandir(getcwd() . self::PATH);
            foreach ($f as $file) {
                if(!in_array($file, ['.', '..']))
                $result[] = self::PATH . $file;
            }
            $this->data = $result;
        }

    }