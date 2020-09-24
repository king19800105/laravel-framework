<?php


namespace App\Components\File;

use Exception;
use App\Exceptions\SystemException;
use Illuminate\Support\Facades\Storage;
use Vtiful\Kernel\{
    Format,
    Excel,
};
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * 文件本地处理实现
 * Class LocalFileHandler
 * @package App\Components
 */
class LocalFileHandler implements FileHandler
{

    /**
     * 导出模式
     *
     * @var int
     */
    protected int $exportModel = self::EXPORT_DEFAULT_MODEL;

    /**
     * 导入模式
     *
     * @var int
     */
    protected int $importModel = self::IMPORT_DEFAULT_MODEL;

    /**
     * 允许导出的后缀
     */
    protected const ALLOW_EXPORT = ['csv', 'xlsx'];

    protected string $sheet = 'Sheet1';

    protected array $row = [];

    protected array $column = [];

    protected array $parseType = [];

    protected bool $headBold;

    public function __construct()
    {
    }

    /**
     * 文件上传操作
     *
     * @param mixed $file
     * @param string $dir
     * @param string $fileName
     * @return mixed
     * @throws SystemException
     */
    public function upload($file, string $dir, string $fileName = '')
    {
        $result = [];
        if (empty($file)) {
            return false;
        }

        if (is_string($file)) {
            $file = request()->file($file);
            if (empty($file)) {
                return false;
            }
        }

        if ($file instanceof UploadedFile) {
            return $this->uploadFiles($file, $dir, $fileName);
        }

        if (is_array($file)) {
            foreach ($file as $item) {
                $result[] = $this->uploadFiles($item, $dir, $fileName);
            }

            return $result;
        }

        return false;
    }

    protected function uploadFiles(UploadedFile $file, $dir, $fileName)
    {
        try {
            if (!empty($fileName)) {
                return Storage::putFileAs($dir, $file, $fileName);
            }

            return Storage::putFile($dir, $file);
        } catch (Exception $e) {
            throw new SystemException(__('reason.file_upload_fail') . ':' . $e->getMessage());
        }
    }

    /**
     * 删除文件
     *
     * @param string $fileName
     * @return mixed
     * @throws SystemException
     */
    public function delete(string $fileName)
    {
        if (!Storage::exists($fileName)) {
            throw new SystemException(__('reason.file_not_find'));
        }

        return Storage::delete($fileName);
    }

    /**
     * 文件下载
     *
     * @param string $fileName 文件名
     * @param string $newName 新文件名
     * @param array $headers 头设置
     * @return mixed
     * @throws SystemException
     */
    public function download(string $fileName, string $newName, array $headers = [])
    {
        if (!Storage::exists($fileName)) {
            throw new SystemException(__('reason.file_not_find'));
        }

        return Storage::download($fileName, $newName, $headers);
    }

    /**
     * 判断文件是否存在
     *
     * @param string $fileName
     * @return bool
     */
    public function exists(string $fileName)
    {
        return Storage::exists($fileName);
    }

    /**
     * 设置模式
     *
     * @param int $model
     * @return $this
     */
    public function setExportModel(int $model): FileHandler
    {
        if (static::EXPORT_FIXED_MEMORY_MODEL === $model) {
            $this->exportModel = $model;
        }

        return $this;
    }

    /**
     * 设置行样式
     *
     * @param string $range
     * @param float $height
     * @param bool $headBold
     * @return $this
     */
    public function setRow(string $range, float $height, bool $headBold = true): FileHandler
    {
        $this->row      = [$range, $height];
        $this->headBold = $headBold;
        return $this;
    }

    /**
     * 设置列样式
     *
     * @param string $range
     * @param float $height
     * @return $this
     */
    public function setColumn(string $range, float $height): FileHandler
    {
        $this->column = [$range, $height];
        return $this;
    }

    /**
     * 设置页
     *
     * @param int $sheet
     * @return $this
     */
    public function setSheet(int $sheet): self
    {
        $this->sheet = 'Sheet' . $sheet;
        return $this;
    }

    /**
     * 导出文件
     *
     * @param string $path 文件位置
     * @param string $fileName 生成的文件名称，要带上后缀
     * @param array $header 头信息
     * @param array $data 导出的数据
     *
     * @return string 返回路径
     * @throws SystemException
     */
    public function excelExport(string $path, string $fileName, array $header, array $data): string
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        if (!in_array($extension, static::ALLOW_EXPORT)) {
            throw new SystemException(__('reason.file_ext_not_allow'));
        }

        $config = ['path' => $path];
        $excel  = $this->getInstance($config);
        $excel  = static::EXPORT_FIXED_MEMORY_MODEL === $this->exportModel
            ? $excel->constMemory($fileName, $this->sheet)
            : $excel->fileName($fileName, $this->sheet);
        if (!empty($this->row) && is_array($this->row)) {
            if ($this->headBold) {
                $format = new Format($excel->getHandle());
                array_push($this->row, $format->bold()->toResource());
            }

            $excel = $excel->setRow(...$this->row);
        }

        if (!empty($this->column) && is_array($this->column)) {
            $excel = $excel->setColumn(...$this->column);
        }

        return $excel
            ->header($header)
            ->data($data)
            ->output();
    }

    /**
     * 导入模式设置
     *
     * @param int $model
     * @return FileHandler
     */
    public function setImportModel(int $model): FileHandler
    {
        if (static::IMPORT_ROW_MODEL === $model) {
            $this->importModel = $model;
        }

        return $this;
    }

    public function setParseType(array $types): FileHandler
    {
        $this->parseType = $types;
        return $this;
    }

    /**
     * 导入excel操作
     *
     * @param string $path 文件的路径
     * @param string $fileName 文件名称
     * @param callable|null $handlerFunc 读取时的处理方式
     *
     * @return array
     * @throws SystemException
     */
    public function excelImport(string $path, string $fileName, callable $handlerFunc = null): array
    {
        $result    = [];
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        if (!in_array($extension, static::ALLOW_EXPORT)) {
            throw new SystemException(__('reason.file_ext_not_allow'));
        }

        $config    = ['path' => $path];
        $excel     = $this->getInstance($config);
        $sheetList = $excel
            ->openFile($fileName)
            ->sheetList();
        if (empty($sheetList) || !is_array($sheetList)) {
            return $result;
        }

        foreach ($sheetList as $item) {
            $excel = $excel->openSheet($item, Excel::SKIP_EMPTY_ROW);
            if (!empty($this->parseType)) {
                $type         = [];
                $sheetNum     = str_replace('Sheet', '', $item);
                $sheetFullNum = $item;
                if (array_key_exists($sheetNum, $this->parseType)) {
                    $type = $this->parseType[$sheetNum];
                }

                if (array_key_exists($sheetFullNum, $this->parseType)) {
                    $type = $this->parseType[$sheetFullNum];
                }

                if (!empty($type)) {
                    $excel = $excel->setType($type);
                }
            }
            if (static::IMPORT_ROW_MODEL === $this->importModel) {
                while ($data = $excel->nextRow()) {
                    $result[$item][] = null !== $handlerFunc
                        ? $handlerFunc($item, $data)
                        : $data;
                }
            } else {
                $result[$item] = null !== $handlerFunc
                    ? $handlerFunc($item, $excel->getSheetData())
                    : $excel->getSheetData();
            }
        }

        return $result;
    }


    /**
     * 获取excel处理对象
     * 固定内存模式导出时使用
     *
     * @param array $config ['path' => '/a/b/c']
     * @return Excel
     */
    protected function getInstance(array $config): Excel
    {
        return app(Excel::class, ['config' => $config]);
    }


}
