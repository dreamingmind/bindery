function PageManager() {
	
	this.table = {};
	this.record = {};
	this.field = {};
	this.fragment = {};
	this._uuid = false;
	
	/**
	 * Add more ID'd elements to the lookup tables
	 * 
	 * @param {Element} node
	 */
	this.add = function(node) {
		if ($(node).attr('id') !== undefined) {
			this.parseFragment(node);
		}
		var workset = $(node).find('[id]');
		for (var c = 0; c < workset.length; c++) {
			this.parseFragment(workset[c]);
		}
//		$(node).find('[id]').each(function () {
//			parseFragment.call(PageManager, this);
//		});
		this._uuid = false;
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
				this._uuid = this.newUuid();
			case 'BUTTON':
			case 'FORM':
			default :
				var node = new ManagedNode($(fragment));
				break;
		}
		node.uuid = this.uuid;
		if (node.constructor === Field) {
			this.storeField(node);
		} else if (node.constructor === ManagedNode) {
			this.storeFragment(node);
		}
	}

	/**
	 * Store a Field object in the lookup structure(s)
	 * 
	 * @param {Field} node
	 */
	this.storeField = function(node) {
		if (this.field[node.field_name] === undefined) {
			this.field[node.field_name] = {};
		}
		this.field[node.field_name][node.uuid] = node;
		
		if (this.record[node.uuid] === undefined) {
			this.record[node.uuid] = {};
		}
		this.record[node.uuid][node.field_name] = node;
		
		if (this.table[node.alias] === undefined) {
			this.table[node.alias] = {
				record: {},
				field: {}
			}	
		}
		this.table[node.alias].record[node.uuid] = this.record[node.uuid];
		this.table[node.alias].field[node.field_name] = this.field[node.field_name];
		
		
	}
	
	/**
	 * Store an ID'd node in the lookup structure(s)
	 * 
	 * @param {ManagedNode} node
	 */
	this.storeFragment = function(node) {
//		if (this.fragments[node.uuid] === undefined) {
//			this.fragments.push(node.uuid);
//		}				
		this.fragment[node.uuid] = node;
	}				
	
} // END OF PAGE MANAGER CLASS

PageManager.prototype = {
	constructor: PageManager,
	get uuid() {
		if (!this._uuid) {
			this._uuid = this.newUuid();
		}
		return this._uuid;
	}
}

/**
 * ManagedNode constructor
 * 
 * @param {Element} node
 * @returns {ManagedNode}
 */
function  ManagedNode(node) {
	this._id = false;
	this.node = node;
}

/**
 * ManagedNode prototype
 * 
 * @type prototype
 */
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
	get uuid() {
		if (!this._id) {
			this.parseId();
		}
		return this._id[2];
	},
	set uuid(uuid) {
		this.node.attr('id', this.baseId + '-' + uuid);
		this.parseId();
	},
	parseId: function () {
		this._id = $(this.node).attr('id').match(/([\w_]+)-*([a-f0-9]*)/);
	}
}

/**
 * Field Constructor
 * 
 * @param {Element} node
 * @returns {Field}
 */
function Field(node) {
	ManagedNode.call(this, node);
}

/**
 * Field prototype
 */
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
		var aliases = this.name.match(/(\[{1}([A-Z]{1}[a-z]+[A-Za-z]*)\]{1})+/);
		return aliases[aliases.length-1];
//		return this.name.match(/\[{1}([A-Z]{1}[a-z]+[A-Za-z]*)\]{1}/)[1];
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

Object.defineProperty(Field.prototype, "field_name", {
    get: function() {
		return this.name.match(/\[([a-z_]*)\]$/)[1]
    },
    enumerable: true,
    configurable: true
});

//[WorkshopSession][0][Date][id]
