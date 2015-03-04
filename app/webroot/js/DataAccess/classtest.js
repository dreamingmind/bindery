var data = {
  A : {
    1 : {
      a : 'A1a val',
      b : 'A1b val'
    },
    2 : {
      a : 'A2a val',
      b : 'A2b val'
    }
  },
  B : {
    1 : {
      a : 'B1a val',
      b : 'B1b val'
    },
    2 : {
      a : 'B2a val',
      b : 'B2b val'
    },
   }
  };
 
var data = [
	'a','b','c','d',{e:['e','f']},'e','f'
]
function table(alias, data) {
	this.alias = alias
	this.raw_data = data;
}

function Iterator(enumerable){
	this._source = enumerable
	this._keys = Object.keys(enumerable);
	this._key = null;
	this._pointer = null;
	this._current = null;
	this.reset();
}

Iterator.prototype = {
	reset: function() {
//		this._keys = this.keys(this._source);
		this._pointer = 0;
		if (this.valid()) {
			this._key = this._keys[this._pointer];
			this._current = this._source[this._key];
		}
	},
	valid: function() {
		return this._pointer + 1 <= this._keys.length;
	},
	key: function() {
		return this._key;
	},
	current: function(){
		return this._current;
	},
	next: function() {
		if (this.valid()) {
			this._key = this._keys[++this._pointer];
			this._current = this._source[this._key];
			return true;
		} else {
			return false;
		}
	}
}

var it = new Iterator(data);
it.reset();
document.write('<p>'+it._source+'</p>');
document.write('<p>'+it._key+'</p>');

while (it.valid()) {
	document.write('<p>'+it.key() + ':' + it.current()+'</p>');
	it.next();
}

function Field(node) {
	this.node = node;
}
Field.prototype = {
	get name() {
		return $(this.node).attr('name');	
	},
	get value() {
		return $(this.node).val();
	},
	set value(newValue) {
		$(this.node).val(newValue);
	}
}
