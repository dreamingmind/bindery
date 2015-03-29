/**
 * PageManager creates cross-indexed lookup tables for elements on the page
 * 
 * Through its add() method, PageManager takes in references to 
 * page elements and parses the elements and possibly thier descendent 
 * elements into various storage objects for later access.
 * 
 * Any ID'd Fieldset or TR will be assumed to contain fields from a 
 * single db record. These parent nodes (Fieldset or TR) will have a uuid appended to thier 
 * id attribute and this uuid will become the reference id for the record, 
 * its fields and any other ID'd descendents in the parent (eg. links or buttons). 
 * 
 * CAVEATS:
 * It's recommended, but not required, that you put ID's on Fieldsets and TRs and use them 
 * as record containment nodes. When detected, they will trigger the generation of a new uuid 
 * (thus starting a new record).
 * If a field is detected in any context and a uuid has not been established, 
 *		a new one will be made. 
 * If a field is found in any context after a uuid has been established, 
 *		that uuid will be assumed to be the record index and the field will be stored accordingly
 * !! If you don't control the containment of record fields, the lookup tables can return bad results
 * 
 * The fields will be stored in three data structures 
 *		with four different methods of access. 
 * - field[fieldname][uuid] = Field object  
 * - record[uuid][fieldname] = Field object
 * - table[TableAlias]['record'][uuid][fieldname] = Field object
 * - table[TableAlias]['field'][fieldname][uuid] = Field object
 * 
 * ID'd nodes that pass through add() that aren't any variety of input 
 * will be stored in the fragment object as a ManagedNode object. 
 * <<< DETAIL WILL BE ADDED HERE >>>
 * 
 * @returns {PageManager}
 */
function PageManager() {
	
	this.table = {};
	this.record = {};
	this.field = {};
	this.fragment = {};
	this._uuid = false;
	
	/**
	 * Add this ID'd element the ID'd elements inside this node to the lookup tables
	 * 
	 * This makes the possibly-dangerous assumption that find() will return an ordered 
	 * node list where we recursively drill to the bottom of each node in turn. If the 
	 * results are horizontal sibling sets or random, the system will fail.
	 * 
	 * Inputs that don't have an identifiable alias in their name attribute will crash this
	 * This means Cake 3 forms are out of the question
	 * 
	 * @param {Element} node
	 */
	this.add = function(node) {
		if ($(node).attr('id') !== undefined) {
			this.parseFragment(node);
		}
		var workset = $(node).find('[id]');
		this.join(workset);
		return node;
	};
	
	/**
	 * Associate these ID'd elements with a new uuid and add them to the lookup tables
	 * 
	 * If you're using join() directly, don't forget:
	 *		Fieldset or TR tags will trigger new uuid groupings
	 * 
	 * @param {Element} node_list The collection of elements you want joined
	 */
	this.join = function(node_list) {
		for (var c = 0; c < node_list.length; c++) {
			this.parseFragment(node_list[c]);
		}
		this._uuid = false;
	};
	
	/**
	 * Get a uuid variant to use as an element id modifier
	 * @returns {String}
	 */
	this.newUuid = function () {
		return 'xxxxxxxxxxxx4xxxyxxxxxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
			var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
			return v.toString(16);
		});
	};
	
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
//		alert('the node uuid will be changed from ' + node.uuid + ' to ' + this.uuid);
		node.uuid = this.uuid;
		$(fragment).data(node);
		if (node.constructor === Field) {
			this.storeField(node);
		} else if (node.constructor === ManagedNode) {
			this.storeFragment(node);
		}
	};

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
			};
		}
		this.table[node.alias].record[node.uuid] = this.record[node.uuid];
		this.table[node.alias].field[node.field_name] = this.field[node.field_name];
		
		this.storeFragment(node);
	};
	
	/**
	 * Store an ID'd node in the lookup structure(s)
	 * 
	 * @param {ManagedNode} node
	 */
	this.storeFragment = function(node) {
		this.fragment[node.fullId] = node;
		
		if (this.fragment[node.uuid] === undefined) {
			this.fragment[node.uuid] = {};
		}
		this.fragment[node.uuid][node.fullId] = node;
		
		if (this.fragment[node.node[0].tagName] === undefined) {
			this.fragment[node.node[0].tagName] = {};
		}
		this.fragment[node.node[0].tagName][node.fullId] = node;
		
//		this.fragment[node.uuid] = node;
//		this.fragment[node.fullId] = node;
	}	;			
	
} // END OF PAGE MANAGER CLASS

PageManager.prototype = {
	constructor: PageManager,
	get uuid() {
		if (!this._uuid) {
			this._uuid = this.newUuid();
		}
		return this._uuid;
	}
};

/**
 * ManagedNode constructor
 * 
 * @param {Element} node
 * @param {string} key
 * @returns {ManagedNode}
 */
function  ManagedNode(node, key) {
	this._id = typeof(key) === undefined ? false : key;
	this.node = node;
};

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
};

/**
 * Field Constructor
 * 
 * @param {Element} node
 * @param {string} key
 * @returns {Field}
 */
function Field(node, key) {
	ManagedNode.call(this, node, key);
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
		return this.name.match(/\[([a-z_]*)\]$/)[1];
    },
    enumerable: true,
    configurable: true
});

//[WorkshopSession][0][Date][id]
