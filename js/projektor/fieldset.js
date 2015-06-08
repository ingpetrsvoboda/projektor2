/**
 * Zobrazí element pokud hodnota je v (uzavřeném) intevalu
 * @param {string} toggledBlockId id zobrazovaného/skrývaného elementu
 * @param {element} sourceElement Element typu input, jehož hodnota se vyhodnocuje
 * @param {integer} lowerBoundValue Dolní mez intervalu
 * @param {integer} upperBoundValue Horní mez intervalu
 * @returns {undefined}
 */
function showWithRequiredInputsIfIn(toggledBlockId, sourceElement, lowerBoundValue, upperBoundValue){
    if ((sourceElement.value>=lowerBoundValue) && (sourceElement.value<=upperBoundValue)) {
        showWithRequiredInputs(toggledBlockId);
    } else {
        hideWithRequiredInputs(toggledBlockId);        
    }
}

function showWithRequiredInputsIfEq(toggledBlockId, sourceElement, criteriaValue){
    if (sourceElement.value == criteriaValue) {
        showWithRequiredInputs(toggledBlockId);
    } else {
        hideWithRequiredInputs(toggledBlockId);        
    }
}

function showWithRequiredInputsIfTrue(toggledBlockId, sourceElement){
    if (sourceElement.value) {
        showWithRequiredInputs(toggledBlockId);
    } else {
        hideWithRequiredInputs(toggledBlockId);        
    }
}

function showWithRequiredInputsIfGt(toggledBlockId, sourceElement, criteriaValue){
    if (sourceElement.value > criteriaValue) {
        showWithRequiredInputs(toggledBlockId);
    } else {
        hideWithRequiredInputs(toggledBlockId);        
    }
}

function showIfNotEmpty(toggledBlockId, sourceElement){
    if (sourceElement.value && 0 !== sourceElement.value.length) {
        show(toggledBlockId);
    } else {
        hide(toggledBlockId);        
    }
}

function showIfNotEqual(toggledBlockId, sourceElement, criteriaValue){
    if (sourceElement.value !== criteriaValue) {
        show(toggledBlockId);
    } else {
        hide(toggledBlockId);        
    }
}

function showIfGt(toggledBlockId, sourceElement, criteriaValue){
    if (sourceElement.value > criteriaValue) {
        show(toggledBlockId);
    } else {
        hide(toggledBlockId);        
    }
}

function hideWithRequiredInputs(toggledBlockId) {
    var toggledElement = document.getElementById(toggledBlockId);
    var inputs = toggledElement.getElementsByTagName('input');
    for(var i = 0;i < inputs.length; i++) {
        inputs[i].required = false;
    } 
    toggledElement.style = 'display:none';
}

function showWithRequiredInputs(toggledBlockId) {
    var toggledElement = document.getElementById(toggledBlockId);
    var inputs = toggledElement.getElementsByTagName('input');
    for(var i = 0;i < inputs.length; i++) {
        inputs[i].required = true;
    } 
    toggledElement.style = 'display:block';        
}

function hide(toggledBlockId) {
    var toggledElement = document.getElementById(toggledBlockId);
    toggledElement.style = 'display:none';
}

function show(toggledBlockId) {
    var toggledElement = document.getElementById(toggledBlockId);
    toggledElement.style = 'display:block';        
}

function toggle(toggledElementId){
    var toggledElement = document.getElementById(toggledElementId);
    if (toggledElement.style.display != 'none') {
        toggledElement.style = 'display:none';
    } else {
        toggledElement.style = 'display:block';        
    }
    return false;
}

function toggleWithRequiredInputs(toggledBlockId) {
    var toggledElement = document.getElementById(toggledBlockId);
    var inputs = toggledElement.getElementsByTagName('input');
    if (toggledElement.style.display != 'none') {
        for(var i = 0;i < inputs.length; i++) {
            inputs[i].required = false;
        } 
        toggledElement.style = 'display:none';
    } else {
        for(var i = 0;i < inputs.length; i++) {
            inputs[i].required = true;
        } 
        toggledElement.style = 'display:block';        
    }
}

function submitForm(submitElement) {
    submitElement.form.submit();
    
    
    return false;
}