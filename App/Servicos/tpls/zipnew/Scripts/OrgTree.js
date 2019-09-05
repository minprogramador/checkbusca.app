
var labelType, useGradients, nativeTextSupport, animate;

(function() {
  var ua = navigator.userAgent,
      iStuff = ua.match(/iPhone/i) || ua.match(/iPad/i),
      typeOfCanvas = typeof HTMLCanvasElement,
      nativeCanvasSupport = (typeOfCanvas == 'object' || typeOfCanvas == 'function'),
      textSupport = nativeCanvasSupport 
        && (typeof document.createElement('canvas').getContext('2d').fillText == 'function');
  //I'm setting this based on the fact that ExCanvas provides text support for IE
  //and that as of today iPhone/iPad current text support is lame
  labelType = (!nativeCanvasSupport || (textSupport && !iStuff))? 'Native' : 'HTML';
  nativeTextSupport = labelType == 'Native';
  useGradients = nativeCanvasSupport;
  animate = !(iStuff || !nativeCanvasSupport);
})();



    

function IniciaJIT(obj){
    //init data

    var json = obj;
   

    //end
    //init Spacetree
    //Create a new ST instance
    var st = new $jit.ST({


        //orientation of the graph
        orientation: "top",

        //id of viz container element
        injectInto: 'infovis',

        //set duration for the animation
        duration: 200,

        //set animation transition type
        transition: $jit.Trans.Back.easeInOut,

        //set distance between node and its children
        levelDistance: 75,
        subtreeOffset: 12,
        siblingOffset : 8,
        //set max levels to show. Useful when used with  
        //the request method for requesting trees of specific depth  
        levelsToShow: 3,

        //enable panning
        Navigation: {
            enable: false,
            panning: false
            

        },

        //set node styles
        Node: {

            overridable: false,
            type: 'rectangle',
            color: '#ffff',
            width: 130,
            //autoWidth: true,
            autoHeight: true,
            align: 'center'

        },

        //set edge styles
        Edge: {
            type: 'arrow',
            overridable: true,
            dim: 10
        },

       Label: {
            overridable: true,
            type: 'HTML' //,    'SVG' 'Native'
//            style: 'white-space: normal;',
//            size: 8,
//            family: 'sans-serif',
//            textAlign: 'center',
//            textBaseline: 'alphabetic',
//            color: '#000'
       },

        //This method is called on DOM label creation.
        //Use this method to add event handlers and styles to
        //your node.
        onCreateLabel: function (label, node) {
            
            label.id = node.id;
            label.innerHTML = node.name;
            label.onclick = function () {
                if (normal.checked) {
                    st.onClick(node.id);
                } else {
                    st.setRoot(node.id, 'animate');
                }
            };

            //set label styles
            var style = label.style;
            style.width = '130.5px';
            style.height = '10px';
            style.cursor = 'pointer';
            style.color = '#333';
            style.fontSize = '0.67em';
            style.textAlign = 'left';
           

            
        },

        

      
        //This method is called right before plotting
        //a node. It's useful for changing an individual node
        //style properties before plotting it.
        //The data properties prefixed with a dollar
        //sign will override the global node style properties.
        onBeforePlotNode: function (node) {
            //add some color to the nodes in the path between the
            //root node and the selected node.
            if (node.selected) {
                node.data.$color = "#E68E15";
            }
            else {
                delete node.data.$color;
                //if the node belongs to the last plotted level
                if (!node.anySubnode("exist")) {
                    //count children number
                    var count = 0;
                    //node.eachSubnode(function(n) { count++; });
                    //assign a node color based on
                    //how many children it has
                    node.data.$color = '#9FC3E3';
                }
            }

            node.data.$height = '75';
           // node.Label.style = 'width: 10px;';

        },

        //Config.collor.allow = true;

        //This method is called right before plotting
        //an edge. It's useful for changihttp://plugins.jquery.com/plugin-tags/graphng an individual edge
        //style properties before plotting it.
        //Edge data proprties prefixed with a dollar sign will
        //override the Edge global style properties.
        onBeforePlotLine: function (adj) {
            if (adj.nodeFrom.selected && adj.nodeTo.selected) {
                adj.data.$color = "#00457C";
                adj.data.$lineWidth = 2;
            }
            else {
                delete adj.data.$color;
                delete adj.data.$lineWidth;
            }
        }
    });

    //load json data
    st.loadJSON(obj);

      

    //compute node positions and layout
    st.compute();
    //optional: make a translation of the tree
    st.geom.translate(new $jit.Complex(-200, 0), "current");
    //emulate a click on the root node.
    st.onClick(st.root);

    st.canvas.type = "3D";

     var top = $jit.id('r-top'), 
        left = $jit.id('r-left'), 
        bottom = $jit.id('r-bottom'), 
        right = $jit.id('r-right'),
        normal = $jit.id('s-normal');

    
    function changeHandler() {
        if(this.checked) {
            top.disabled = bottom.disabled = right.disabled = left.disabled = true;
            st.switchPosition(this.value, "animate", {
                onComplete: function(){
                    top.disabled = bottom.disabled = right.disabled = left.disabled = false;
                }
            });
        }
    };
    
   };