function PageManager() {
	
	this.fields = [];
	this.fragments = [];
	this.uuid
	
	/**
	 * Add more ID'd elements to the lookup tables
	 * 
	 * @param {Element} node
	 */
	this.add = function(node) {
//		this.field.push(new Field(node));
		$($(node).wrap('div')).find('[id]').each(function () {
			parseFragment.call(PageManager.rows, this);
		});
	}
	
	/**
	 * Get a uuid variant to use as an element id modifier
	 * @returns {String}
	 */
	this.newUuid = function () {
		return 'xxxxxxxxxxxx4xxxyxxxxxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
			var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
			return v.toString(16);
		});
	}
	
	/**
	 * Fold nodes into the lookup structures
	 * 
	 * Only elements with ID attributes come here. 
	 * The IDs get a uuid appended so fields an such can be 
	 * gathered together in groupings (eg. records) 
	 * 
	 * BUSINESS RULE:
	 * TR and FIELDSET will start a new uuid grouping, 
	 * all other elements use the current uuid if it exists 
	 * and will set one if it doesn't exist.
	 * 
	 * @param {Element} fragment
	 */
	this.parseFragment = function (fragment) {
		switch (fragment.tagName) {
			case 'INPUT':
			case 'SELECT':
			case 'TEXTAREA':
				var node = new Field($(fragment));
				break;
			case 'TR':
			case 'FIELDSET':
				this.uuid = this.newUuid();
			case 'BUTTON':
			case 'FORM':
			default :
				var node = new ManagedNode($(fragment));
				break;
		}
		node.uuId = this.newUuid();
		if (Field.isPrototypeOf(node)) {
			this.storeField(node);
		} else if (ManagedNode.isPrototypeOf(node)) {
			this.storeFragment(node);
		}
	}

	/**
	 * Store a Field object in the lookup structure(s)
	 * 
	 * @param {Field} node
	 */
	this.storeField = function(node) {
		if (this.fields[node.uuId] === 'undefined') {
			this.fields[node.uuId] = [];
		}				
		this.fields[node.uuId][node.name] = node;
	}
	
	/**
	 * Store an ID'd node in the lookup structure(s)
	 * 
	 * @param {ManagedNode} node
	 */
	this.storeFragment = function(node) {
		if (this.fragments[node.uuId] === 'undefined') {
			this.fragments[node.uuId] = [];
		}				
		this.fragments[node.uuid].push(node);
	}				
	
} // END OF PAGE MANAGER CLASS


function  ManagedNode() {
	this._id = false;
	this.node = 'node';
}

ManagedNode.prototype = {
	constructor: ManagedNode,
	get fullId() {
		if (!this._id) {
			this.parseId();
		}
		return this._id[0];
	},
	get baseId() {
		if (!this._id) {
			this.parseId();
		}
		return this._id[1];
	},
	get uuId() {
		if (!this._id) {
			this.parseId();
		}
		return this._id[2];
	},
	set uuId(uuid) {
		this.node.attr('id', this.baseId + '-' + uuid);
	},
	parseId: function () {
		this._id = $(this.node).attr('id').match(/([\w_]+)-*([a-f0-9]*)/);
	}
}

function Field() {
	ManagedNode.call(this);
}

Field.prototype = Object.create(ManagedNode.prototype, {
		constructor: {
			configurable: true,
			enumerable: true,
			value: Field,
			writable: true
		}
	});

Object.defineProperty(Field.prototype, "name", {
    get: function() {
		return $(this.node).attr('name');
    },
    enumerable: true,
    configurable: true
});

Object.defineProperty(Field.prototype, "alias", {
    get: function() {
		return this.name.match(/\[{1}([A-Z]{1}[a-z]+[A-Za-z]*)\]{1}/)[1];
    },
    enumerable: true,
    configurable: true
});

Object.defineProperty(Field.prototype, "value", {
    get: function() {
		return $(this.node).val();
    },
    set: function(newValue) {
		$(this.node).val(newValue);
    },
    enumerable: true,
    configurable: true
});



