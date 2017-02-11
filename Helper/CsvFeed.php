<?php
/**
 * Copyright © 2017 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\File\Csv;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\Filesystem\Io\File as IoFile;
use Symfony\Component\Filesystem\Exception\IOException;
use Magento\Framework\Message\ManagerInterface;

class CsvFeed extends Csv
{

    /**
     * feed media location directory
     */
    const FEED_DIR = 'productfeed';

    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * @var IoFile
     */
    private $ioFile;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * CsvFeed constructor.
     * @param File $file
     * @param Repository $repository
     * @param DirectoryList $directoryList
     * @param IoFile $ioFile
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        File $file,
        Repository $repository,
        DirectoryList $directoryList,
        IoFile $ioFile,
        ManagerInterface $messageManager
    )
    {
        parent::__construct($file);
        $this->repository = $repository;
        $this->directoryList = $directoryList;
        $this->ioFile = $ioFile;
        $this->messageManager = $messageManager;
    }

    /**
     * @param string $file
     * @param array $data
     * @return bool
     */
    public function saveFile($file = 'default.csv', $data = [])
    {

//        echo '<pre>';
//        print_r($data);
//        exit();

        //todo get te attributes so you prepend to the first element for header

        $ds = DIRECTORY_SEPARATOR;
        $mediaDir = $this->directoryList->getPath(DirectoryList::MEDIA);

        try {
            $this->ioFile->mkdir($mediaDir . $ds . self::FEED_DIR, 0775);

            $fileWithPath = $mediaDir .
                DIRECTORY_SEPARATOR .
                self::FEED_DIR .
                DIRECTORY_SEPARATOR .
                $file;

            $this->saveData($fileWithPath, $data);

        } catch (IOException $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }

        return true;
    }

}