<?php



namespace Katten\Purge\Factory;


use Katten\Purge\Exceptions\UnableToReadInFileException;



class FileFactory extends Factory {


    /**
     * Retrieve the contents of a file
     * 
     * @param string $file
     *      The file name or url to load from
     * 
     * @return string
     *      The contents of the file
     */ 
    public static function buildFromFile($file) {
    
        $output = @file_get_contents($file);
        
        
        if (!$output) {
            throw new UnableToReadInFileException("Unable to load file: $file");
        }
        
        return $output;
    }


}
