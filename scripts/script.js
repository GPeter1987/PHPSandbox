const travelTypes = [
    "Gyalogtúra",
    "Városnézés",
    "Autós utazás",
    "Repülős utazás"
];

let menuItems = document.querySelectorAll('.nav-item');
for(let menuItem of menuItems){
    menuItem.onclick = function(event){
        /* le kell szedni az active classt mielőtt új helyre tennénk, 
        hogy egyszerre biztos csak egy legyen aktív */
        clearActiveClassMarker();
        event.target.classList.add('active');
        //showContent();
    }
}

function clearActiveClassMarker(){
    let items = document.querySelectorAll('.active');
    for(let item of items){
        if(item.classList.contains('active')){
            item.classList.remove('active');
        }
    }
}

//Elrejtjük a contentet és az active kapcsolóó alapján mutatjuk őket
let dinamicContetns = document.querySelectorAll('.dinCont');
function hideContent(contents){
    for(let dc of contents){
        dc.style.display = 'none';
    }
}
//hideContent(dinamicContetns);

function showContent(){
    //előbbelrejtjük a tartalmat
    //hideContent(dinamicContetns);
    //Na ebből elvileg csak egy lesz szóval mehet az active[0]-val a munka.
    let active = document.querySelectorAll('.active')[0].id;
    switch(active){
        case "travelMenu":
            document.getElementById('travelPage').style.display = 'block';
            break;
        case "poiMenu":
            document.getElementById('poiPage').style.display = 'block';
            break;
        case "costMenu":
            document.getElementById('costPage').style.display = 'block';
            break;
        case "diaryMenu":
            document.getElementById('diaryPage').style.display = 'block';
            break;
        case "packageMenu":
            document.getElementById('packagePage').style.display = 'block';
            break;
        default:
            console.log("Valami nem nyert az activnál.");
    }
}

if(document.getElementById('newTravelBtn') !== null){
    document.getElementById('newTravelBtn').onclick = function(){
        renderNewTravelForm();
    }
}

function renderNewTravelForm(){
    //Create form template
    let newTravelForm = `
    <div class="col-md-3">
        <a id="backBtn" href="index.php" class="btn btn-secondary">Vissza az előző oldalra</a>
    </div>
    <div class="col-md-7 border m-1 p-2">
        <h4 class="text text-center">Új Utazás</h4>
        <form id="newTravelForm" action="newTravel.php" method="POST">
            <div class="form-group">
                <label for="name">Név</label>
                <input type="text" name="name" id="name" class="form-control" require>
            </div>
            <div class="form-group">
            <label for="start">Kezdete</label>
                <input type="date" name="start" id="start" class="form-control" require>
            </div>
            <div class="form-group">
                <label for="end">Vége</label>
                <input type="date" name="end" id="end" class="form-control" require>
            </div>
            <div class="form-group">
                <label for="type">Típusa</label>
                <select class="form-control" name="type" id="type">
                    ${generateTravelTypeOptions(travelTypes)}
                </select>
            </div>
            <div class="form-group">
                <label for="desc">Leírás</label>
                <textarea class="form-control" name="desc" id="desc" rows="5" cols="50"></textarea>
            </div>
            <div class="form-group">
                <label for="data1">Adat 1</label>
                <input class="form-control" type="text" name="data1" id="data1">
            </div>
            <div class="form-group">
                <label for="data2">Adat 2</label>
                <input class="form-control" type="text" name="data2" id="data2">
            </div>
            <div class="form-group">
                <label for="data3">Adat 3</label>
                <input class="form-control" type="text" name="data3" id="data3">
            </div>
            <div class="form-group mt-2">
                <input class="form-control btn btn-primary" type="submit" value="Hozzáadás">
            </div>
        </form>
    </div>`;

    document.getElementById('travelPage').innerHTML += newTravelForm;
}

function generateTravelTypeOptions(travelTypes){
    let options = "";
    for(let type of travelTypes){
        options += `<option value="${travelTypes.indexOf(type)}">${type}</option>`;
    }
    return options;
}


//Új csomag hozzá adásánál a súly kiszedése és a darabbszámal együtt való állítása
if(document.getElementById('packageParcSelected') !== null){
    let selectedParcField = document.getElementById('packageParcSelected');
    let selectedWeightField = document.getElementById('selPackageParcWeight');
    let quantityFieald = document.getElementById('pacParcQuantity');
    let weightSum = 0; 
    let quantityWeight = 0;

    selectedParcField.onchange = function(event){
        console.log(event.target.value);
           
        let options = document.querySelectorAll('option');
        for(let opt of options){
            if(opt.value === event.target.value){
                quantityWeight = opt.dataset.weight;
                break;
            }
        }
    
        //A súlyt meg kell szorozni a darabszámmal
        weightSum = quantityWeight * quantityFieald.value;
        console.log(`Ez itt a súly a végén: ${weightSum}`);
    
        selectedWeightField.value = weightSum;
        selectedWeightField.setAttribute('value', selectedWeightField.value);
    };

    quantityFieald.onchange = function(event){
        selectedWeightField.value = quantityWeight * event.target.value;
        selectedWeightField.setAttribute('value', selectedWeightField.value);
    };
}