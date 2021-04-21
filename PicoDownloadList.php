<?php

/**
 * PicoDownloadList - List files from a folder for download
 *
 * @author  Gonçalo Lopes <goncalo.lopes@fccn.pt>
 * @version 0.1
 */
final class PicoDownloadList extends AbstractPicoPlugin
{
    /**
     * API version used by this plugin
     *
     * @var int
     */
    const API_VERSION = 2;

    /**
     * This plugin is enabled by default?
     *
     * @var boolean
     */
    protected $enabled = true;

    /**
     * Triggered before Pico renders the page
     * @return void
     */
    public function onPageRendering(&$templateName, array &$twigVariables)
    {
        // Search for files shortcodes allover the content
        preg_match_all('#\[download *.*?\]#s', $twigVariables['content'], $matches);

        // Make sure we found some shortcodes
        if (count($matches[0]) > 0) {
            // Get page content
            $content = &$twigVariables['content'];

            // Walk through shortcodes one by one
            foreach ($matches[0] as $match) {
                // Get the directory to get files from
                preg_match_all('#\[download *(.*?)\]#s', $match, $directory);

                $dir = $twigVariables['base_dir'] . "/" . $directory[1][0];
                $url = $twigVariables['base_url'] . "/" . $directory[1][0];

                // Replace the shortcodes with HTML elements
                $content = preg_replace('#\[download *.*?\]#s', $this->list_files($dir, $url), $content, 1);
            }
        }
    }

    /**
     * Creates a HTML list displaying the file names, sizes and links for download
     * @return string
     */
    private function list_files($dir, $url)
    {
        // Open unordered list tag
        $list = "<ul>";

        // Checks if the specified directory is really a directory
        if (is_dir($dir)) {
            // Used scandir to order files by name
            foreach (scandir($dir) as $file) {
                // Ignore "." and ".."
                if ($file != "." && $file != "..") {
                    // Path to the file in the filesystem
                    $file_dir = "$dir/$file";

                    // Path to the file in 
                    $file_url = "$url/$file";

                    // Check if the current file is a directory
                    if (is_dir($file_dir)) {
                        // Adds the directory name
                        $list .= "<li>
                            <b>$file</b>
                        </li>";

                        // Lists the files inside the current directory in a new sub list
                        $list .= $this->list_files($file_dir, $file_url);
                    }
                    // The file is a regular file and not a directory
                    else {
                        // Splits the file name by "."
                        $parts = explode(".", $file);

                        // The last element is the extension
                        $ext = strtoupper(array_pop($parts));

                        // The rest is the actual file name
                        $file_name = implode(".", $parts);

                        // Adds the link for the file and its extension and size
                        $list .= "<li>
                            <a href=\"$file_url\" download>$file_name</a> [" . $ext . ", " . $this->file_size($file_dir) . "]
                        </li>";
                    }
                }
            }
        }
        // Close unordered list tag
        $list .= "</ul>";

        return $list;
    }

    /**
     * Returns the file size in B or KB
     * @return string
     */
    private function file_size($file)
    {
        // Get file size
        $size = filesize($file);

        // Return size as KB if size is greater than 1024
        if ($size > 1024) {
            return (int)ceil($size / 1024) . " KB";
        }
        // Return size as B otherwise
        return $size . " B";
    }
}
