<?php

class PostMaxSizeChecker {

    /**
     * アップロード総量がアップロード制限以下かどうかの判定
     * maxsizeCheck
     *
     * @return boolean
     */
    public function check() {

        // php.iniの設定値を取得して比較対象との単位を合わせるためbyte変換する
        $upload_max_filesize = (int) $this->__toByte(ini_get('upload_max_filesize'));
        $post_max_size = (int) $this->__toByte(ini_get('post_max_size'));
        $content_length = (int) env('CONTENT_LENGTH');

        if (empty($upload_max_filesize) || empty($post_max_size)) {
            return false;
        }

        // 低いほうを比較対象とする
        if ($post_max_size < $upload_max_filesize) {
            $compare = $post_max_size;
        } else {
            $compare = $upload_max_filesize;
        }

        return ( $compare >= $content_length );
    }

    /**
     * byte変換
     * ※10MBの文字列を10485760のようなbyte数に変換
     *
     * @param string $size ini_get('upload_max_filesize')の戻り値である「10M」のような文字列
     * @return (number|boolean)
     */
    private function __toByte($size = null) {
        if (empty($size)) {
            return false;
        }

        preg_match_all('/^(\d*)(K|M|G|T|P)$/i', $size, $matches);

        $base = null;
        if (!empty($matches[1][0])) {
            $base = $matches[1][0];
        }
        $unit = null;
        if (!empty($matches[2][0])) {
            $unit = strtoupper($matches[2][0]);
        }
        if (empty($base) || empty($unit)) {
            return false;
        }

        switch ($unit) {
            case 'K':
                $result = $base * 1024;
                break;
            case 'M':
                $result = $base * 1024 * 1024;
                break;
            case 'G':
                $result = $base * 1024 * 1024 * 1024;
                break;
            case 'T':
                $result = $base * 1024 * 1024 * 1024 * 1024;
                break;
            case 'P':
                $result = $base * 1024 * 1024 * 1024 * 1024 * 1024;
                break;
            default:
                $result = false;
                break;
        }
        return $result;
    }

}