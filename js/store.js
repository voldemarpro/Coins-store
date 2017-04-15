// Конструктор объекта "магазин"
var store = function(attr) {
	this.amountCtrl;
	this.prodCtrl; // интерфейс (:select) для выбора продукта
	this.currCtrl; // интрефейс (:radio) для выбора валюты
	this.payCurrencies;
	this.products;
	if (typeof attr == 'object') {
		if (attr.hasOwnProperty('prodCtrl'))
			this.prodCtrl = attr.prodCtrl;
		if (attr.hasOwnProperty('currCtrl'))
			this.currCtrl = attr.currCtrl;
		if (attr.hasOwnProperty('payCurrencies'))
			this.payCurrencies = attr.payCurrencies;
		if (attr.hasOwnProperty('products'))
			this.products = attr.products;
		if (attr.hasOwnProperty('amountCtrl'))
			this.amountCtrl = attr.amountCtrl;
		if (typeof this.products == 'object' && this.products != {} && this.amountCtrl && this.payCurrencies && this.currCtrl && this.prodCtrl) {
			var _self = this;
			this.prodCtrl.change(function() {
				_self.product = this.value;
				_self.payCurrency = $(':radio').filter(':checked').val();
				_self.orderTotal = _self.payCurrencies[_self.payCurrency]['factor'] * _self.products[this.value]['price'];
				_self.orderTotal = Math.round(_self.orderTotal);
				_self.amountCtrl.text(_self.orderTotal + ' ' + _self.payCurrencies[_self.payCurrency]['name']);
			});
			this.prodCtrl.change();
			this.currCtrl.change(function() {
				if (this.checked) {
					_self.payCurrency = this.value;
					_self.orderTotal = _self.payCurrencies[_self.payCurrency]['factor'] * _self.products[_self.product]['price'];
					_self.orderTotal = Math.round(_self.orderTotal);
					_self.amountCtrl.text(_self.orderTotal + ' ' + _self.payCurrencies[_self.payCurrency]['name']);
				}
			});
			this.currCtrl.first().prop({checked:true});		
		}
	}
};