// Javascript functions for Masonry topics course format
// based on YUI Masonry (http://yui-masonry.appspot.com/)

M.masonry = {};

M.masonry.init = function(Y, cfg) {

    function Masonry() {
         Masonry.superclass.constructor.apply(this, arguments);
    }

    Masonry.NAME = 'masonry';

    Masonry.ATTRS = {
        node: {
            setter: function (node) {
                var n = Y.one(node);
                if (!n) {
                    var n = Y.one('#coursemasonry');
                    if (!n) {
                        Y.fail('Masonry: Invalid Node Given: ' + node);
                    }
                }
                return n;
            }
        },
        isResizable: {
            value: true
        },
        isAnimated: {
            value: true
        },
        animationOptions: {
            value: { duration: .5 }
        },
        gutterWidth: {
            value: 0
        },
        isRTL: {
            value: false
        },
        isFitWidth: {
            value: true
        },
        containerStyle: {
            value: { position: 'relative' }
        },
        columnWidth: {
            value: 2
        },
        itemSelector: {
            value: '.section.main'
        }
    };

    Y.extend(Masonry, Y.Base, {

        initializer: function () {
            this._create();
            this._init();
        },

        destructor: function () {
            this.bricks
                .removeClass('masonry-brick')
                .setStyles({ position: '', top: '', left: '' });
            this.get('node')
                .detach('masonry|*')
                .removeClass('masonry')
                .setStyles(this.originalStyle);
            Y.detach('masonry|*');
        },

        _outerWidth: function (node) {
            return node ? node.get('offsetWidth') + parseInt(node.getStyle('marginLeft'), 10) + parseInt(node.getStyle('marginRight'), 10) : 0;
        },

        _outerHeight: function (node) {
            return node ? node.get('offsetHeight') + parseInt(node.getStyle('marginTop'), 10) + parseInt(node.getStyle('marginBottom'), 10) : 0;
        },

        _filterFindBricks: function (elems) {
            var selector = this.get('itemSelector'),
                result = elems;
            if (selector) {
                result = new Y.NodeList();
                elems.each(function (node) {
                    result = result.concat(node, node.all(selector));
                });
                result = result.filter(selector);
            }
            return result;
        },

        _getBricks: function (elems) {
            var bricks = this._filterFindBricks(elems)
                             .setStyle('position', 'absolute')
                             .addClass('masonry-brick');
            return bricks;
        },

        _create: function () {
            this.styleQueue = [];
            var node = this.get('node'),
                elemStyle = node.getDOMNode().style,
                containerStyle = this.get('containerStyle'),
                prop,
                columnWidth = this.get('columnWidth'),
                instance = this;
            this.originalStyle = {height: elemStyle.height || ''};
            for (prop in containerStyle) {
                if (containerStyle.hasOwnProperty(prop)) {
                    this.originalStyle[prop] = elemStyle[prop] || '';
                }
            }
            node.setStyles(containerStyle);
            this.horizontalDirection = this.get('isRTL') ? 'Right' : 'Left';
            this.offset = {
                x: parseInt(node.getStyle('padding' + this.horizontalDirection), 10),
                y: parseInt(node.getStyle('paddingTop'), 10)
            };
            this.horizontalDirection = this.horizontalDirection.toLowerCase();
            this.isFluid = columnWidth && typeof columnWidth === 'function';
            setTimeout(function () { instance.get('node').addClass('masonry'); }, 0);
            if (this.get('isResizable')) {
                Y.on('masonry|windowresize', function () {
                    instance.resize();
                });
            }
            this.reloadItems();
        },

        _init: function (callback) {
            this._getColumns();
            this._reLayout(callback);
        },

        layout: function (bricks, callback) {
            var i, len, unusedCols, styleFn,  obj, style,
                containerSize = {},
                animOpts = this.get('animationOptions');
            bricks.each(function (node) {
                this._placeBrick(node);
            }, this);
            containerSize.height = Math.max.apply(Math, this.colYs) + 'px';
            if (this.get('isFitWidth')) {
                unusedCols = 0;
                i = this.cols;
                while (--i) {
                    if (this.colYs[i] !== 0) {
                        break;
                    }
                    unusedCols++;
                }
                containerSize.width = (this.cols - unusedCols) * this.columnWidth - this.get('gutterWidth') + 'px';
            }
            this.styleQueue.push({el: this.get('node'), style: containerSize});
            styleFn = !this.isLaidOut ? 'setStyles' : (
                this.get('isAnimated') ? 'transition' : 'setStyles'
            );
            for (i = 0, len = this.styleQueue.length; i < len; i++) {
                obj = this.styleQueue[i];
                style = obj.style;
                if ('transition' === styleFn) {
                    if (style.top) {
                        style.top += 'px';
                    }
                    if (style[this.horizontalDirection]) {
                        style[this.horizontalDirection] += 'px';
                    }
                    style = Y.merge(style, animOpts);
                }
                obj.el[styleFn](style);
            }
            this.styleQueue = [];
            if (callback) {
                callback.call(bricks);
            }
            this.isLaidOut = true;
        },

        _getColumns: function () {
            var node = this.get('node'),
                container = this.get('isFitWidth') ? node.get('parentNode') : node,
                containerWidth = parseInt(container.getStyle('width'), 10) || 0,
                columnWidth = this.get('columnWidth'),
                gutterWidth = this.get('gutterWidth');
            this.columnWidth = this.isFluid ? columnWidth(containerWidth) : columnWidth || this._outerWidth(this.bricks.item(0)) || containerWidth;
            this.columnWidth += gutterWidth;
            this.cols = Math.floor((containerWidth + gutterWidth) / this.columnWidth);
            this.cols = Math.max(this.cols, 1);
        },

        _placeBrick: function (brick) {
            var colSpan, groupCount, groupY, groupColY, j, minimumY, shortCol, i, len, position, setHeight, setSpan;
            colSpan = Math.ceil(this._outerWidth(brick) / this.columnWidth);
            colSpan = Math.min(colSpan, this.cols);
            if (colSpan === 1) {
                groupY = this.colYs;
            } else {
                groupCount = this.cols + 1 - colSpan;
                groupY = [];
                for (j = 0; j < groupCount; j++) {
                    groupColY = this.colYs.slice(j, j + colSpan);
                    groupY[j] = Math.max.apply(Math, groupColY);
                }
            }
            minimumY = Math.min.apply(Math, groupY);
            shortCol = 0;
            for (i = 0, len = groupY.length; i < len; i++) {
                if (groupY[i] === minimumY) {
                    shortCol = i;
                    break;
                }
            }
            position = { top: minimumY + this.offset.y };
            position[this.horizontalDirection] = this.columnWidth * shortCol + this.offset.x;
            this.styleQueue.push({el: brick, style: position});
            setHeight = minimumY + this._outerHeight(brick);
            setSpan = this.cols + 1 - len;
            for (i = 0; i < setSpan; i++) {
                this.colYs[shortCol + i] = setHeight;
            }
        },

        resize: function () {
            var prevColCount = this.cols;
            this._getColumns();
            if (this.isFluid || this.cols !== prevColCount) {
                this._reLayout();
            }
        },

        _reLayout: function (callback) {
            var i = this.cols;
            this.colYs = [];
            while (i--) {
                this.colYs.push(0);
            }
            this.layout(this.bricks, callback);
        },

        reloadItems: function () {
            this.bricks = this._getBricks(this.get('node').get('children'));
            return this;
        },

        reload: function (callback) {
            this.reloadItems();
            this._init(callback);
            return this;
        },

        appended: function (content, isAnimatedFromBottom, callback) {
            if (isAnimatedFromBottom) {
                this._filterFindBricks(content).setStyles({top: this.get('node').get('region').height});
                var instance = this;
                setTimeout(function () { instance._appended(content, callback); }, 1);
            } else {
                this._appended(content, callback);
            }
            return this;
        },

        _appended: function (content, callback) {
            var newBricks = this._getBricks(content);
            this.bricks = this.bricks.concat(newBricks);
            this.layout(newBricks, callback);
        },

        remove: function (content) {
            var self = this;
            content.each(function () {
                self.bricks.splice(self.bricks.indexOf(this), 1);
                this.remove(true);
            });
            return this;
        },

        happen: function () {
            Y.log("Masonry", "info",  "masonry");
        },


    });

    Y.Masonry = Masonry;
    M.masonry = new Y.Masonry(cfg);

    var dock = M.core.dock;
    if (dock) {
        Y.use('moodle-core-dock', function() {
            dock = M.core.dock.get();
            dock.on('moodle-core-dock:itemschanged', M.masonry.resize(), this);
            dock.on('dock:itemschanged', M.masonry.resize(), this);
            //dock.on('itemschanged', M.masonry.resize());
            //M.core.dock.loader.delegationEvents.push(M.masonry.delegate('resize', M.masonry.resize()));
        });
        //M.core.dock.loader.delegationEvents.push(body.delegate('click', callback, '.moveto'));
        //Y.Global.on('moodle-core-dock:itemschanged', M.masonry.resize(), M.masonry);
        //Y.Global.on('moodle-core-dock:*', M.masonry.happen(), M.masonry);
        //Y.Global.on('*:itemschanged', M.masonry.happen(), M.masonry);
        //Y.Global.on('dock:itemadded', M.masonry.happen(), M.masonry);
        //Y.Global.on('moodle-core-dock:*', M.masonry.happen(), M.masonry);
        //Y.one('#dock').on('click', M.masonry.resize(), dock);
        //Y.one('.moveto.customcommand.requiresjs').on('click', M.masonry.resize(),dock);
        //Y.Global.on('itemschanged', M.masonry.resize());
        //dock.after('itemschaged', M.masonry.resize());

        //Y.on('windowresize', M.masonry._reLayout(), this);
        //dock._dock.on('dock:itemschanged', M.masonry._reLayout());
    }
};
