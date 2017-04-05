<!DOCTYPE html>
<html>
<head>
	<title>Mockup Generator</title>
	<link rel="stylesheet" type="text/css" href="css/semantic.min.css" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/semantic.min.js"></script>

	<style type="text/css">
		.canvas.container{
			margin-top: 70px;
		}
		.main.container .ui.segment img {
			width: 100%;
			height: 100%;
			cursor: pointer;
		}
		.main.container .ui.segment {
			height:40vh;
		}
		.main.container .ui.segment {
			/*height:40vh;*/
			/*text-align: center;*/
		}
		.canvas.container .ui.segment canvas{
			position: relative;
			left:17.5%;
			width: 65%;
			height: 60%;
		}
		#download_mockup {
			display: none;
		}
	</style>

	<script type="text/javascript">
		$(document).ready(function () {
			function loadCanvas(imgUrl, screenshotImgUrl=null) {
				var canvas = document.getElementById('myCanvas');
				var context = canvas.getContext('2d');

				var backgroundImageObj = new Image();
				backgroundImageObj.onload = function () {
					context.drawImage(this, 0,0);
				};
				backgroundImageObj.src = imgUrl;
				if(screenshotImgUrl!= null) {
					var screenshotImageObj = new Image();
					screenshotImageObj.onload = function () {
						context.drawImage(this, 266,295,420,257);
					};
					screenshotImageObj.src = screenshotImgUrl;
					$('#download_mockup').show();
				} else {
					$('#download_mockup').hide();
				}
			}
			loadCanvas('back.jpg');
			
			$('.upload.button').click(function() {
				console.log('clicked');
				$('#file_upload_form_input').click();
			});
			
			$('#file_upload_form_input').on('change', submitImage);
			$('.button.reset').click(function () {
				loadCanvas('back.jpg');
			});
			
			function submitImage() {
				var file_data = $('#file_upload_form_input').prop('files')[0];
		        var form_data = new FormData();

		        if (file_data === undefined) {
		            alert('Please select a file');
		            return false;
		        }
		        var extension = file_data.name.split(".")[1];
		        var size = file_data.size;

		        if (extension != "jpeg" && extension != "jpg" && extension != "png" && extension != "PNG" && extension != "JPG" && extension != "JPEG" ) {
		            alert("Please upload a jpeg or png Image");
		            return false;
		        } else {
		            form_data.append('file', file_data);
		        }
		        $.ajax({
		            url: 'upload.php',
		            cache: false,
		            contentType: false,
		            processData: false,
		            data: form_data,
		            type: 'post',
		            dataType: "JSON",
		            success: function(response) {
		            	console.log(response);
		            	if(parseInt(response['code'])==0) {
		            		loadCanvas('back.jpg', response['message']);
		            	} else {
		            		alert(response['message']);
		            	}
		            },
		            error: function(data) {
		                console.log(data);
		            }
		        });
			}

			function downloadCanvas(link, canvasId, filename) {
			    link.href = document.getElementById(canvasId).toDataURL();
			    link.download = filename;
			}
			$('#download_mockup').click(function () {
				console.log('rty');
				downloadCanvas(this, 'myCanvas', 'mockup.png');
			});
		});
	</script>
</head>
<body>
	<div class="ui large top fixed menu">
		<div class="ui container">
			<a class="active item">Mockup Generator</a>
			<div class="right menu">
				<a class="item" id="download_mockup">Download Image</a>
			</div>
		</div>
		</div>
	</div>
	<!-- <div class="ui main container">
		<div class="ui three column grid">
			<div class="column">
				<div class="ui segment">
					<img src="back.jpg" />
				</div>
			</div>
			<div class="column">
				<div class="ui segment">
					<img src="back1.jpg" />
				</div>
			</div>
			<div class="column">
				<div class="ui segment">
					<img src="back2.jpg" />
				</div>
			</div>
		</div>
		<div class="ui three column centered grid">
			<div class="column">
				<div class="ui segment">
					<img src="back3.jpg" />
				</div>
			</div>
			<div class="column">
				<div class="ui segment">
					<img src="back5.jpg" />
				</div>
			</div>
		</div>
	</div> -->
	<div class="ui canvas container">
		<div class="ui segment">
			<div class="ui one centered column grid">
				<div class="column">
					<div class="ui centered segment">
						<canvas id="myCanvas" width="960px" height="640px" style="border:1px solid #d3d3d3;">
						Your browser does not support the HTML5 canvas tag.
						</canvas>
					</div>
				</div>
			</div>
			<div class="ui six column centered grid">
				<div class="column">
					<button class="ui green button upload">Upload Screenshot</button>
				</div>
				<div class="column">
					<input id="file_upload_form_input" type="file" name="screenshot_image" hidden="hidden">
					<button class="ui orange button reset">Reset Mockup Image</button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>