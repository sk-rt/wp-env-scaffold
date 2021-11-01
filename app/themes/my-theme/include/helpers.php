<?php

/***************************************************************


Helper functions


 ***************************************************************/

namespace App\Helper;

/**
 * テンプレートパーツ 取得
 * WPの `get_template_part()` を出力せずにhtmlで返す
 * @param $temp_path string テンプレートパス
 * @return string - html
 */
function get_template_part_html($temp_path)
{
    ob_start();
    $view = get_template_part($temp_path);
    $view = ob_get_contents();
    ob_end_clean();
    return $view;
}

/**
 * ファイルの更新日を取得
 * @param string $filepath
 * @return string|null
 */
function get_filetime(string $filepath)
{
    if (file_exists($filepath)) {
        return filemtime($filepath);
    } else {
        return null;
    }
};

/**
 * タームの作成
 *
 * @param array $term_array
 * @param string $taxonomy
 * @return void
 * @see https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/wp_insert_category
 */
function insert_new_terms(array $term_array, string $taxonomy)
{
    if (!$taxonomy || !$term_array) {
        return;
    }
    foreach ($term_array as $term) {
        $is_term = term_exists($term['category_nicename'], $taxonomy);
        if ($is_term === 0 || $is_term === null) {
            $term += array(
                'taxonomy' => $taxonomy,
            );
            wp_insert_category($term, false);
        }
    }
}
/* ========================================

Logger

======================================== */
/**
 * Logファイルに変数を出力
 */
function debug_log($var)
{
    \error_log(var_export($var, true) . "\n", 3, __DIR__ . '/../log/debug.log');
};
