<?php
	// Installed the need packages with Composer by running:
	// $ composer require aws/aws-sdk-php
	use Aws\S3\S3Client;
	use Aws\S3\Exception\S3Exception;

	function uploadImg($urlImg, $cli, $uid){
        
        $bucketName = 'mailcooking';
		$filePath = $urlImg;
		$keyName = basename($filePath);
        $IAM_KEY = 'AKIAIBWMTNQPZZOLJZPA';
		$IAM_SECRET = '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';
		// Set Amazon S3 Credentials
		$s3 = S3Client::factory(
			array(
				'credentials' => array(
					'key' => $IAM_KEY,
					'secret' => $IAM_SECRET
				),
				'version' => 'latest',
				'region'  => 'eu-west-3',
				'scheme' => 'http',
			)
		);
	  // the public url. It will look like:
	  // https://s3.us-east-2.amazonaws.com/YOUR_BUCKET_NAME/image.png
		try {
	
			if (!file_exists('/tmp/tmpfile')) {
				mkdir('/tmp/tmpfile');
			}
			
			// Create temp file

            $tempFilePath = '/tmp/tmpfile/' . $keyName;
			$tempFile = fopen($tempFilePath, "w") or die("Error: Unable to open file.");
			$fileContents = file_get_contents($filePath);
			$tempFile = file_put_contents($tempFilePath, $fileContents);
	
			$result = $s3->putObject(
				array(
					'Bucket'=>	$bucketName,
					'Key' =>   $cli.'/'.$uid.'/'.$keyName,
					'SourceFile' => $tempFilePath,
                    'StorageClass' => 'REDUCED_REDUNDANCY',
                    'ACL' => 'public-read'
				)
            );
            
            if($result['@metadata']['statusCode'] == '200'){
                return $result['@metadata']['effectiveUri'];
            }
            
		} catch (S3Exception $e) {
            echo $e->getMessage();
            return false;
		} catch (Exception $e) {
            echo $e->getMessage();
            return false;
		}
	}
?>