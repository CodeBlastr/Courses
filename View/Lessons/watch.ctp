<?php
$this->Html->css('/courses/css/courses', null, array('inline'=>false));
?>
<div class="lessons watch" id="lessonWatch">
	<div class="row">
		<div id="lessonWatchCanvas" class="span9">
			<?php echo $this->element('literallycanvas/literallycanvas', array('id' => 'lessonWatchNotepad')) ?>
		</div>
		<div class="span3">
			<div id="lessonChatbox">
				#lessonChatbox
			</div>
			<div id="lessonUserlist">
				#lessonUserlist
			</div>
			<a href="javascript:sendCanvas()">sendCanvas()</a>
			<a href="javascript:receiveCanvas()">receiveCanvas()</a>
			
		</div>
	</div>
	<div id="lessonWatchResources" class="span3">
		<?php
		if ( !empty($lesson['Media']) ) {
			echo '<b>Lesson Materials</b>';
			echo $this->element('Courses.displayMaterialsList', array('media' => $lesson['Media']));
		}
		?>
	</div>
</div>
<canvas id="receivingCanvas" height="539" width="870"></canvas>

<script type="text/javascript">
	/**
	 * 192.168.1.8:1337
	 */

	var canvasData;
	var oldCanvasData;
	var presenterCanvas = document.getElementById("lessonWatchNotepad");
	var receiverCanvas = document.getElementById("receivingCanvas");
	var	receiverContext = receiverCanvas.getContext("2d");

//	var buffer = document.createElement('canvas');
//	buffer.width = receiverCanvas.width;
//	buffer.height = receiverCanvas.height;
//	buffer.getContext("2d").clearRect(0, 0, buffer.height, buffer.width);

	function sendCanvas() {
		canvasData = presenterCanvas.toDataURL();
	}

	function receiveCanvas() {
		if ( canvasData !== oldCanvasData ) {
			console.log('updating..');
			var image = new Image();
			image.onload = function() {
				//receiverContext.drawImage(buffer, 0, 0);//
				receiverContext.clearRect(0, 0, receiverCanvas.width, receiverCanvas.height);
				console.log(receiverCanvas.width);
				receiverContext.drawImage(image, 0, 0);
			};
			
			image.src = oldCanvasData = canvasData;
		}
	}

	function update() {
		sendCanvas();
		receiveCanvas();
	}

	function setFPS(fps) {
		return Math.round(1000 / fps);
	}

$(function() {
  setInterval(update, setFPS(5));
});
</script>
<!--
<script type="text/javascript">

	var canvasData;
	var oldCanvasData;
	var presenterCanvas = document.getElementById("lessonWatchNotepad");
	var receiverCanvas = document.getElementById("receivingCanvas");
	var	receiverContext = receiverCanvas.getContext("2d");


	var buffer = document.createElement('canvas');
	buffer.width = receiverCanvas.width;
	buffer.height = receiverCanvas.height;
	//buffer.getContext("2d").clearRect(0, 0, buffer.height, buffer.width);

	function getFromCanvas() {
		canvasData = presenterCanvas.toDataURL();
	}

	function sendToCanvas() {
		//clearReceiver();
		if ( canvasData !== oldCanvasData ) {
			//receiverContext.drawImage(buffer, 0, 0);
			var image = new Image();
			image.onload = function() {
				receiverContext.drawImage(buffer, 0, 0);
				receiverContext.drawImage(image, 0, 0);
			};
			image.src = oldCanvasData = canvasData;
		}
	}

//	 function clearReceiver() {
//		 HEIGHT = document.getElementById('receivingCanvas').clientHeight;
//		 WIDTH = document.getElementById('receivingCanvas').clientWidth;
//		 receiverContext.clearRect(0, 0, HEIGHT, WIDTH);
//		 receiverContext.fillStyle = "#FAF7F8";
//		 rect(receiverContext, 0, 0, WIDTH, HEIGHT);
//	 }

    function rect(context, x, y, w, h) {
		context.beginPath();
		context.rect(x,y,w,h);
		context.closePath();
		context.fill();
    }

	function update() {
		//console.log('updating..');
		getFromCanvas();
		sendToCanvas();
	}

$(function() {
	setInterval(update, 20);
});
</script>-->
