<?php

namespace Mcustiel\Phiremock\Common\Utils;

class FileSystem
{
    /**
     * @param string $path
     * @return string
     */
    public function getRealPath($path)
    {
        $existentPath = $this->normalizePath($path);
        $tail = [];

        $pathArray = explode('/', $existentPath);
        while (!file_exists($existentPath)) {
            array_unshift($tail, array_pop($pathArray));
            $existentPath = implode('/', $pathArray);
        }

        return str_replace(
            DIRECTORY_SEPARATOR,
            '/',
            $existentPath . '/' . implode(DIRECTORY_SEPARATOR, $tail)
        );
    }

    /**
     * @param string $path
     * @return string
     */
    private function normalizePath($path)
    {
        $path = str_replace(DIRECTORY_SEPARATOR, '/', $path);
        if ($path[0] !== '/') {
            $path = getcwd() . '/' . $path;
        }

        return $path;
    }
}
