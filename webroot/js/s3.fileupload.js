jQuery('.fine-uploader-s3').fineUploaderS3({
		debug: true,    
		template: 'qq-template-s3',
		request: {
			endpoint: "https://demo-data-canqualifyer.s3.amazonaws.com/",
			accessKey: "AKIAXLWV2NB43IZMYI3M"
		},
		signature: {
			endpoint: "https://demo.canqualifier.com/endpoint.php"
		},
		uploadSuccess: {
			endpoint: "https://demo.canqualifier.com/endpoint.php?success",
			params: {
				isBrowserPreviewCapable: qq.supportedFeatures.imagePreviews
			}
		},
		cors: {
                expected: true
            },
            chunking: {
                enabled: true
            },
            resume: {
                enabled: true
            },
            deleteFile: {
                enabled: true,
                method: "POST",
                endpoint: "/uploads/removeFile"
            },
            validation: {
                itemLimit: 5,
                sizeLimit: 15000000
            },
            thumbnails: {
                placeholders: {
                    notAvailablePath: "../vendors/s3.fine-uploader/placeholders/not_available-generic.png",
                    waitingPath: "../vendors/s3.fine-uploader/placeholders/waiting-generic.png"
                }
            },
            callbacks: {
                onComplete: function(id, name, response) {
                    var previewLink = qq(this.getItemByFileId(id)).getByClass('preview-link')[0];

                    if (response.success) {
                        previewLink.setAttribute("href", response.tempLink)
                    }
                }
            }
        });