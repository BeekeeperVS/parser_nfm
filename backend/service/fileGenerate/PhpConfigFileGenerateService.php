<?php

namespace app\service\fileGenerate;

class PhpConfigFileGenerateService implements PhpGenerateServiceInterface
{
    private $fileContent = "<?php\n\n return [\n";

    public array $options;


    /**
     * {@inheritDoc}
     */
    public function put(int|string $key, int|string|array $value): void
    {
        $this->options[$key] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function convertOptions(): void
    {
        $tabCount = 1;
        $tabs = $this->getTabs($tabCount);
        foreach ($this->options as $key => $value) {
            if (is_array($value)) {
                $this->fileContent .= $this->generateItem($key, $value, $tabCount);
                $this->fileContent .= "\n";
            } else {
                $this->fileContent .= "$tabs'$key' => '$value',";
                $this->fileContent .= "\n";
            }
        }
        $this->fileContent .= "];";
    }

    /**
     * {@inheritDoc}
     */
    public function install($filename, $dir = ''): bool
    {
        $this->convertOptions();
        if (file_put_contents($dir . '/' . $filename, $this->fileContent)) {
            return true;
        }
        return false;

    }

    /**
     * @param string $key
     * @param array $arr
     * @param int $depth
     * @return string
     */
    private function generateItem(string $keyTitle, array $arr, int $depth): string
    {
        $tabsCurrent = $this->getTabs($depth);
        $tabsNexItem = $this->getTabs(++$depth);
        $data = "$tabsCurrent'$keyTitle' => [\n";
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $data .= $this->generateItem($key, $value, $depth);
                $data .= "\n";
            } else {
                $data .= "$tabsNexItem'$key' => '$value',";
                $data .= "\n";
            }
        }
        $data .= "$tabsCurrent],";
        return $data;
    }

    private function getTabs(int $countTab): string
    {
        $tabs = '';
        if ($countTab) {
            while ($countTab > 0) {
                $tabs .= "\t";
                $countTab--;
            }
        }
        return $tabs;
    }
}