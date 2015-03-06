function PageManager() {
	
	this.field = [];
	
	this.add = function(node) {
		this.field.push(new Field(node));
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

} // END OF PAGE MANAGER CLASS

function Field() {
	ManagedNode.call(this);
//	this._id = false;
//	this.node = 'node';
}

Field.prototype = Object.create(ManagedNode.prototype);


function viewprop(obj) {
	for (var prop in obj) {
		alert('<p class="properties">' + prop + ' : ' + obj[prop] + '</p>');
	}
};

viewprop(Field);


Field.prototype = {
	constructor: Field,
//		_id: false,
	get name() {
		return $(this.node).attr('name');
	},
	get value() {
		return $(this.node).val();
	},
	set value(newValue) {
		$(this.node).val(newValue);
	},
	get alias() {
		return this.name.match(/\[{1}([A-Z]{1}[a-z]+[A-Za-z]*)\]{1}/)[1];
	},
}
viewprop(Field);

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


