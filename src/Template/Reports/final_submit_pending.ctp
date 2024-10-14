<?php
echo "Total Suppliers to Scan: " . count($supplierListAll) . "<br>";
foreach ($supplierList as $key => $contractor){
    $activeUser = array();
    $activeUser['contractor_id'] = $contractor['id'];
    $activeUser['role_id'] = 2;
    $total_complete = true;
    $services = $this->Category->getServices($contractor['id']);
    if(!empty($services)) {
        ?>
        <?php
        foreach ($services as $service_id => $service_name) {
            if ($service_id == 4 || $service_id==3) {
                continue;
            }

            $final_submit = true;
            if($service_id == 2){
                $categories = $this->Category->getInsCategories($activeUser, $service_id, false);
            }else{
                $categories = $this->Category->getCategories($activeUser, $service_id, false);
            }

            if(!empty($categories)) {
                foreach($categories as $cat) {
                    if($cat['getPerc'] !='100%') {
                        $final_submit = false;
                        $total_complete = false;
                        break;
                    }
                }

                $i=0;
                $todayDate = array();
                /*foreach($categories as $cat) {
                    if(!empty($cat['childrens'])) { // year_based
                        foreach ($cat['childrens'] as $key=>$value) {
                            foreach ($value['cat'] as $childcats) { //pr($childcats);
                                if($service_id==2 && !empty($categories)) {
                                    $curYear = date('Y');
                                    $ansDate=array();
                                    if($childcats['name']=="General Liability") {
                                        $ansDate = $this->Category->checkAns(43,$contractor['id']);
                                    }elseif($childcats['name']=="Automobile Liability"){
                                        $ansDate = $this->Category->checkAns(55,$contractor['id']);
                                    }elseif($childcats['name']=="Excess/Umbrella Liability"){
                                        $ansDate = $this->Category->checkAns(65,$contractor['id']);
                                    }elseif($childcats['name']=="Workers Compensation"){
                                        $ansDate = $this->Category->checkAns(456,$contractor['id']);
                                    }

                                    if(!empty($ansDate)){
                                        $ansDate = max($ansDate);
                                        $todayDate = date('Y-m-d');
                                        $ansDate = date('Y-m-d', strtotime($ansDate. "-30 days"));
                                    }

                                    if($key >$curYear){
                                        if($childcats['getPerc'] == '100%')
                                        { continue; }
                                        // elseif($ansDate <= $todayDate || $childcats['name']== 'Workers Compensation' ||$childcats['getPerc'] != '0%' ) {
                                        elseif($ansDate <= $todayDate ||$childcats['getPerc'] != '0%' ) {

                                        }
                                    }else{
                                        if($childcats['getPerc'] == '100%')
                                        { continue; }
                                        else {
                                            ?>
                                            <?php
                                        }
                                    }
                                }else{
                                    if($childcats['getPerc'] == '100%')
                                    { continue; }
                                    else {

                                    }
                                }
                            }
                        }
                    }
                    elseif(!empty($cat['child'])) { // sub_cat
                        foreach ($cat['child'] as $key=>$value) {
                            if($value['getPerc'] == '100%')
                            { continue; }
                            else {
                                ?>
                                <?php
                            } }
                    }
                    else {
                        if($cat['getPerc'] == '100%')
                        { continue; }
                        else {
                            ?>
                            <?php
                        }
                    }
                }*/
                ?>
                <?php
            }
            else { // service doesn't have category
                $total_complete = false;
            }
        } // foreach $services
        ?>
        <?php
            if($total_complete) {
            echo $this->Html->link('Please Submit Your Data', ['controller' => 'Contractors', 'action' => 'dashboard', $contractor['id']], ['escape'=>false, 'title'=>'Please Submit Your Data', 'target' => "_blank"]);
        }
    } // if waiting_on = Contractor
}
?>