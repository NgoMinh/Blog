(function($){
	$.fn.myPlugin = function(options)
	{
		var defauts = {
			"renderWidth"     : 316,
			"renderHeight"    : 400,
			"sliderContainer" : null,
			"linkModel"       : null,
			"minCamDistance"  : null,
			"maxCamDistance"  : null
		};

		var parametres = $.extend(defauts, options);
		return this.each(function()
		{
			$(this).find(".icon-expand").fadeOut();

			$(this).hover(function (event){
				$(this).find(".icon-expand").fadeIn(100);
			},function(){
				$(this).find(".icon-expand").fadeOut(100);
			});

			parametres.sliderContainer.slider({
				orientation : 'horizontal',
				range       : 'min',
				min         : parametres.minCamDistance,
				max         : parametres.maxCamDistance,
				slide       : function (event, ui){
					majDistance(ui.value);
				}
			});

			var scene = new THREE.Scene();
			var camera = new THREE.PerspectiveCamera(75, parametres.renderWidth/parametres.renderHeight, 0.1, 1000);
			var renderer = new THREE.WebGLRenderer({
				antialias : true
			});
			renderer.setSize(parametres.renderWidth, parametres.renderHeight);
			renderer.setClearColor( 0xffffff, 0);
			$(this).append(renderer.domElement);
			var controls = new THREE.OrbitControls( camera , renderer.domElement );
			var majDistance = function (value){
				controls.minDistance = value;
				controls.maxDistance = value;
			};
			majDistance(parametres.minCamDistance);
			var loader = new THREE.ColladaLoader();
			loader.options.converUpAxis = true;
			loader.load( parametres.linkModel ,function (collada){
				dae = collada.scene;
				dae.scale.x = dae.scale.y = dae.scale.z = 2;
				dae.rotation.x =+5;
				scene.add(dae);
				camera.lookAt(dae);
			});
			var render = function (){
				requestAnimationFrame(render);
				controls.update();
				renderer.render(scene, camera);
			};
			render();
		});
	};
})(jQuery);