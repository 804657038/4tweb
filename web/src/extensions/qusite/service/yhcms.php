<?php
/**
 * 
 *
 * @author ���� <yzhou91@aliyun-inc.com> QQ:89652519
 * @copyright ?2003-2103 phpwind.com
 * @license http://www.yhcms.com
 * @package wind
 */


class yhcms {
  /**
 * д�ļ�
 *
 * @param string $fileName �ļ�����·��
 * @param string $data ����
 * @param string $method ��дģʽ
 * @param bool $ifLock �Ƿ����ļ�
 * @param bool $ifCheckPath �Ƿ����ļ����еġ�..��
 * @param bool $ifChmod �Ƿ��ļ����Ը�Ϊ�ɶ�д
 * @return bool �Ƿ�д��ɹ�   :ע��rb+�������ļ������ص�false,����wb+
 */
function writeover($fileName, $data, $method = 'rb+', $ifLock = true, $ifCheckPath = true, $ifChmod = true) {
	$fileName = $this->escapePath($fileName, $ifCheckPath);
	touch($fileName);
	$handle = fopen($fileName, $method);
	$ifLock && flock($handle, LOCK_EX);
	$writeCheck = fwrite($handle, $data);
	$method == 'rb+' && ftruncate($handle, strlen($data));
	fclose($handle);
	$ifChmod && @chmod($fileName, 0777);
	return $writeCheck;
}

	/**
	 * ·��ת��
	 * @param $fileName
	 * @param $ifCheck
	 * @return string
	 */
	function escapePath($fileName, $ifCheck = true) {
		if (!$this->_escapePath($fileName, $ifCheck)) {
			exit('Forbidden');
		}
		return $fileName;
	}
		/**
	 * ˽��·��ת��
	 * @param $fileName
	 * @param $ifCheck
	 * @return boolean
	 */
	function _escapePath($fileName, $ifCheck = true) {
		$tmpname = strtolower($fileName);
		$tmparray = array('://',"\0");
		$ifCheck && $tmparray[] = '..';
		if (str_replace($tmparray, '', $tmpname) != $tmpname) {
			return false;
		}
		return true;
	}
}
?>