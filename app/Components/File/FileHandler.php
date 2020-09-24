<?php


namespace App\Components\File;

/**
 * Interface FileHandler
 * @package App\Components\Contract
 */
interface FileHandler
{
    /**
     * 内存使用模式
     */
    public const
        EXPORT_DEFAULT_MODEL= 1, EXPORT_FIXED_MEMORY_MODEL = 2, IMPORT_DEFAULT_MODEL = 3, IMPORT_ROW_MODEL = 4;

    public function exists(string $fileName);

    public function upload(string $uploadName, string $dir, string $fileName = '');

    public function download(string $fileName, string $newName, array $headers = []);

    public function delete(string $fileName);

    public function setRow(string $range, float $height, bool $headBold = true): self;

    public function setColumn(string $range, float $height): self;

    public function setSheet(int $sheet): self;

    public function setExportModel(int $model): self;

    public function setImportModel(int $model): self;

    public function setParseType(array $types): self;

    public function excelExport(string $path, string $fileName, array $header, array $data): string;

    public function excelImport(string $path, string $fileName, callable $handlerFunc = null);
}
