<?php


namespace App\Service\Upload;

use Qcloud\Cos\Client;
use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\Config;

class CosAdapter extends AbstractAdapter
{
    protected $bucket;

    protected $client;


    public function __construct($config)
    {
        $this->setClient(new Client([
            'region' => $config['region'],
            'credentials' => ['secretId' => $config['secret_id'], 'secretKey' => $config['secret_key']]]));
        $this->setBucket($config['bucket']);
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setBucket($bucket)
    {
        $this->bucket = $bucket;
    }

    public function getBucket()
    {
        return $this->bucket;
    }
    /**
     * 判断文件是否存在
     * @param string $path
     * @return bool
     * @author yangyifan <yangyifanphp@gmail.com>
     */
    public function has($path)
    {
        return $this->getMetadata($path) != false ;
    }
    /**
     * 读取文件
     *
     * @param $file_name
     * @author yangyifan <yangyifanphp@gmail.com>
     */
    public function read($path)
    {
        return ['contents' => file_get_contents($this->applyPathPrefix($path)) ];
    }
    /**
     * 获得文件流
     *
     * @param string $path
     * @return array
     * @author yangyifan <yangyifanphp@gmail.com>
     */
    public function readStream($path)
    {
        return ['stream' => fopen($this->applyPathPrefix($path), 'r')];
    }

    /**
     * 写入文件
     * @param string $path
     * @param string $contents
     * @param Config $config
     * @return array|false
     */
    public function write($path, $contents, Config $config)
    {
        try {
            $result = $this->client->putObject([
                'Bucket' => $this->bucket,
                'Key'    => $path,
                'Body'   => $contents,
            ]);
            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 写入文件流
     * @param string $path
     * @param resource $resource
     * @param Config $config
     */
    public function writeStream($path, $resource, Config $config)
    {
        try {
            $result = $this->client->putObject([
                'Bucket' => $this->bucket,
                'Key'    => $path,
                'Body'   => $resource,
            ]);
            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 更新文件
     * @param string $path
     * @param string $contents
     * @param Config $config
     * @return array|false|void
     */
    public function update($path, $contents, Config $config)
    {

    }

    /**
     * 更新文件流
     * @param string $path
     * @param resource $resource
     * @param Config $config
     * @return array|false|void
     */
    public function updateStream($path, $resource, Config $config)
    {

    }

    /**
     * 重命名文件
     * @param string $path
     * @param string $newpath
     * @return bool|void
     */
    public function rename($path, $newpath)
    {

    }

    /**
     * 复制文件
     * @param string $path
     * @param string $newpath
     * @return bool|void
     */
    public function copy($path, $newpath)
    {

    }

    /**
     * 删除文件
     * @param string $path
     * @return bool|void
     */
    public function delete($path)
    {

    }

    /**
     * 删除目录
     * @param string $dirname
     * @return bool|void
     */
    public function deleteDir($dirname)
    {

    }

    /**
     * 创建文件夹
     * @param string $dirname
     * @param Config $config
     * @return array|false|void
     */
    public function createDir($dirname, Config $config)
    {

    }

    /**
     * 设置文件模式
     * @param string $path
     * @param string $visibility
     * @return array|false|void
     */
    public function setVisibility($path, $visibility)
    {

    }

    /**
     * 列出目录中的文件
     * List contents of a directory.
     *
     * @param string $directory
     * @param bool   $recursive
     *
     * @return array
     */
    public function listContents($directory = '', $recursive = false)
    {

    }

    /**
     * 获取文件元信息
     * Get all the meta data of a file or directory.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getMetadata($path)
    {

    }

    /**
     * 获取文件大小
     * Get the size of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getSize($path)
    {

    }

    /**
     * 获取文件Mime类型
     * Get the mimetype of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getMimetype($path)
    {

    }

    /**
     * 获取文件最后修改时间
     * Get the last modified time of a file as a timestamp.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getTimestamp($path)
    {

    }

    /**
     * 获得文件模式
     * Get the visibility of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getVisibility($path){

    }
}