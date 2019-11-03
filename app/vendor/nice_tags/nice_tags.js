// ---------------
// NiceTags for JS
// ---------------

// (c) FloppySoftware

// Revisions:

// 01 Dec 2017 : mgl : Start.

// tagsDivId     = Where to write the content. Usually a DIV inside a FORM.
// tagsInputName = Name atribute for INPUTs, written as NAME="tagsInputName[]".
// tagsVarName   = Name of NiceTags object to manipulate the array.
function NiceTags(tagsDivId, tagsInputName, tagsVarName, tagsFgColor, tagsBgColor) {
	var p_tagsDivId     = tagsDivId;
	var p_tagsInputName = tagsInputName;
	var p_tagsVarName   = tagsVarName;
	var p_tagsFgColor   = tagsFgColor;
	var p_tagsBgColor   = tagsBgColor;
	
	var p_tags = [];
	
	//
	var drawTag = function(tagIndex) {
		if(tagIndex == 0) {
			document.getElementById(p_tagsDivId).innerHTML = "";
		}
		
		document.getElementById(p_tagsDivId).innerHTML +=
			'<input type="hidden" name="' + p_tagsInputName + '[]" value="' + p_tags[tagIndex].id + '">' +
			'<span class="w3-tag w3-round w3-border w3-small" style="color:' + p_tagsFgColor + ';background-color:' + p_tagsBgColor + ';margin-right:0.5em;">' +
			p_tags[tagIndex].name +
			'&nbsp;<span class="w3-border-left x-clickable" onclick="' + p_tagsVarName + '.remove(' + tagIndex + ');">' +
			'&nbsp;<b>&times;</b></span></span>';
	}
	
	//
	var refresh = function() {
		document.getElementById(p_tagsDivId).innerHTML = "&nbsp;";
		
		for(var i = 0; i < p_tags.length; ++i) {
			drawTag(i);
		}
	}
	
	//
	this.clear = function() {
		document.getElementById(p_tagsDivId).innerHTML = "&nbsp;";
		p_tags = [];
	}
		
	//
	this.add = function(tagId, tagName) {
		if(tagName != '') {
			for(var i = 0, k = p_tags.length; i < k; ++i) {
				if(p_tags[i].id == tagId) {
					return;
				}
			}
			
			p_tags.push({id: tagId, name: tagName});
			drawTag(p_tags.length - 1);
		}
	}
	
	//
	this.remove = function(tagIndex) {
		p_tags.splice(tagIndex, 1);
		refresh();
	}
	
	//
	this.get = function() {
		return p_tags;
	}
}