# External sort PHP

An attempt at external sort algorithm in PHP.

## Run the program

`php start.php input/FILENAME`

### Options

Set file size limit in MB: `php start.php input/FILENAME 1`

# Practical considerations

In practice, using PHP's built in sort function will run much faster and more efficiently. [This is because the core function is written in C.](https://stackoverflow.com/questions/990301/building-quicksort-with-php)

# Other

This current commit doesn't work with large files. It will split large files into smaller, sorted files (default 1MB) but the merge aspect hasn't yet been implemented.
