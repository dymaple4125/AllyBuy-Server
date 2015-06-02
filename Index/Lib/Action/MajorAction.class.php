<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MajorAction extends Action{

    //viewall majors under a specific department
    public function viewall(){

        //create major model instance
        $db     =   M('major');

        //get department id from URL
        $department_id  =   I('param.2');

        //echo $department_id;
        //get result data
        $result =   $db ->table(array('zebra_major'=>'major','zebra_department'=>'department','zebra_university'=>'university'))
                        ->field('major.major_id, major.major_name, major.deadline, department.department_name, university.university_name')
                        ->where("major.department_id=department.department_id "
                                . "AND department.university_id=university.university_id "
                                . "AND major.department_id=$department_id")
                        ->select();

        //return JSON format data
        $this->ajaxReturn($result,'JSON');
    }

    //view a specific major information
    public function view(){

        //create major model instance
        $db =   M('major');

        //get major id from URL
        $major_id  =   I('param.2');

        //get result data
        $result =   $db ->table(array('zebra_major'=>'major','zebra_follow'=>'follow'))
                        ->field('major.*, count(follow.user_id) as followers')
                        ->where("major.major_id=follow.major_id "
                                . "AND major.major_id=$major_id")
                        ->select();

        //return JSON format data
        $this->ajaxReturn($result,'JSON');
    }

    //recommand group of major base on user information
    public function recommandbyuser(){

        //major model instance
        $user_db    =   M('user');
        $major_db   =   M('major');

        $user_id   =   I('param.2');  //user_id
        $index  =   I('param.3'); //index
        $step   =   I('param.4');  //step

        $result =   $user_db->table(array('zebra_user'=>'user','zebra_experience'=>'experience'))
                            ->field('subject_id, country_id, university_ids, TOEFL, IELTS, GRE, GMAT, GPA, value')
                            ->where("user.experience_id=experience.experience_id "
                                    ."AND user_id=$user_id")
                            ->select();
        //print_r($result);

        //extract all variables from array
        extract($result[0]);




        //if subject id is not provided then find match all subject
        $where  =   $subject_id!=0? " AND major.subject_id=$subject_id ":'';

        //create other conditions
        $where	.=   " AND major.experience_min<=$value "
                    ."AND ((major.TOEFL_min<=$TOEFL) "
                    ."OR (major.IELTS_min<=$IELTS)) "
                    ."AND ((major.GRE_min<=$GRE) "
                    ."OR (major.GMAT_min<=$GMAT)) "
                    ."AND (major.GPA_min<=$GPA)";

        //check whether intent university equals empty
        if(!empty($university_ids)){
            //split the university ids string to get university id array
            $university_id_array    =   explode(';', $university_ids);

            //at first get rid of the last one, because last one is empty
            unset($university_id_array[count($university_id_array)-1]);

            $university_id_condition   =   '(';
            //create keyword based where statment
            $counter	=	0;
            $len	=	count($university_id_array);

            foreach($university_id_array as $university_id){
                if(!empty($university_id)){
                    $university_id_condition .= "university.university_id=$university_id";

                    //add OR between each keyword
                    if($counter!=$len-1)	$university_id_condition.=" OR ";

                    //add counter
                    $counter++;

                }
            }

            $university_id_condition .= ')';

            $where .= " AND $university_id_condition";
        }

        //get recommanded majors
        $result =   $major_db ->table(array('zebra_major'=>'major','zebra_department'=>'department','zebra_university'=>'university','zebra_district'=>'district'))
                        ->field('major.major_id, major.major_name, major.deadline, department.department_name, university.university_name')
                        ->where("major.department_id=department.department_id "
                                . "AND department.university_id=university.university_id "
                                . "AND university.district_id=district.district_id "
                                . "AND district.country_id=$country_id"
                                . $where)
                        ->order('major.deadline DESC')
                        ->limit("$index, $step")
                        ->select();

        //return result as JSON
        $this->ajaxReturn($result);

    }

    //recommand group of major base on current selected major
    public function recommandbymajor(){

        //major model instance
        $db =   M('major');

        $major_id   =   I('param.2');  //major_id
        $index      =   I('param.3'); //index
        $step       =   I('param.4');  //step

        $result =   $db ->table(array('zebra_major'=>'major','zebra_department'=>'department','zebra_university'=>'university','zebra_district'=>'district'))
                        ->field('major.major_name, major.subject_id, district.country_id')
                        ->where("major.department_id=department.department_id "
                                . "AND department.university_id=university.university_id "
                                . "AND university.district_id=district.district_id "
                                . "AND major_id=$major_id")
                        ->select();

        extract($result[0]);

        //first translate all major name to lower case, easy for looking for key words
        $major_name	=	strtolower($major_name);

        //explode major name by space to seperate all words
        $keyword_array	=	explode(' ', $major_name);

        //words thats need to be get rid of from key word array
        $common_word_array	=	array("an","as","of","and","in","deploma","postgraduate","master","ma","mssc","llm","administration","to","other");


        //loop to get rid of unrelative words
        foreach($common_word_array as $word)
            foreach($keyword_array as $key=>$value)
                if($value==$word) unset($keyword_array[$key]);

        //re organize key word array index
        $keyword_array	=	array_values($keyword_array);

        //create keyword based where statment
        $counter	=	0;
        $len	=	count($keyword_array);

        if($len==0) $this->ajaxReturn(msg('此专业没有任何关键词'));

        //beginning of statement
        $keyword_statement	='(';

        //need to translate to SQL statement for checking
        foreach($keyword_array as $keyword){
                //$keyword_statement.="majors.major_name LIKE '%$keyword%' OR departments.department_name LIKE '%$keyword%'";
                $keyword_statement.="major.major_name LIKE '%$keyword%'";

                //add OR between each keyword
                if($counter!=$len-1)	$keyword_statement.=" OR ";

                //add counter
                $counter++;
        }

        $keyword_statement.=')';

        //get recommanded majors
        $result =   $db ->table(array('zebra_major'=>'major','zebra_department'=>'department','zebra_university'=>'university','zebra_district'=>'district'))
                        ->field('major.major_id, major.major_name, major.deadline, department.department_name, university.university_name')
                        ->where("major.department_id=department.department_id "
                                . "AND department.university_id=university.university_id "
                                . "AND university.district_id=district.district_id "
                                . "AND district.country_id=$country_id "
                                . "AND major.subject_id=$subject_id "
                                . "AND major.major_id<>$major_id "
                                . "AND ".$keyword_statement)
                        ->order('major.deadline DESC')
                        ->limit("$index, $step")
                        ->select();

        //return result as JSON
        $this->ajaxReturn($result);
    }

    //search major with major name keyword
    public function search(){

        //create major model instance
        $db =   M('major');

        //get index and step
        $index      =    I('param.2');
        $step       =    I('param.3');
        //get values from post
        $country_id =   I('post.country_id');
        $university_id  =   I('post.university_id');
        $department_id  =   I('post.department_id');
        $subject_id =   I('post.subject_id');
        $keyword    =    I('post.keyword');

        //initial condition
        $condition  =   '';

        //get condition from department -> university -> country
        if($department_id!='0') $condition .= " AND department.department_id=$department_id";
        else if($university_id!='0') $condition .= " AND university.university_id=$university_id";
        else if($country_id!='0') $condition .= " AND country.country_id=$country_id";

        //add subject condition
        if($subject_id!='0') $condition .= " AND major.subject_id=$subject_id";

        //add keyword condition
        if(!empty($keyword)) $condition .= " AND major.major_name LIKE %$keyword%";

        //echo $condition;

        //get result data
        $result =   $db ->table(array('zebra_major'=>'major','zebra_department'=>'department','zebra_university'=>'university','zebra_district'=>'district','zebra_country'=>'country'))
                        ->field('major.major_id, major.major_name, major.deadline, department.department_name, university.university_name')
                        ->where("major.department_id=department.department_id "
                                . "AND department.university_id=university.university_id "
                                . "AND university.district_id=district.district_id "
                                . "AND district.country_id=country.country_id"
                                . $condition)
                        ->order('major.deadline DESC')
                        ->limit("$index, $step")
                        ->select();

        //return as JSON
        $this->ajaxReturn($result);
    }
}
