<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserAction extends Action{

    public function viewAll(){

        $db     =   M('user');
        $result =   $db->select();

        //以JSON数据格式返回
        $this->ajaxReturn($result,'JSON');
    }

    //get a specific user info based on user id
    public function view(){

        //user model instance
        $db =   M('user');

        //get user id
        $user_id    =   I('param.2');

        //get user info
        $result =   $db ->table(array('zebra_user'=>'user', 'zebra_subject'=>'subject', 'zebra_country'=>'country', 'zebra_experience'=>'experience', 'zebra_background'=>'background'))
                        ->field('user.*, subject.subject_name, country.country_name, experience.experience_name, background.background_name')
                        ->where("user.country_id=country.country_id "
                                . "AND user.subject_id=subject.subject_id "
                                . "AND user.experience_id=experience.experience_id "
                                . "AND user.background_id=background.background_id "
                                . "AND user_id=$user_id")
                        ->select();

        //return as JSON
        $this->ajaxReturn($result);
    }

    //update GCM
    public function updateGCM(){

    }

    //update users' application info based on user id
    public function updateAppInfo(){

        //user model instance
        $db =   M('user');

        //get user id
        $user_id    =   I('param.2');

        //get update values
        $data['country_id']     =   I('post.country_id');
        $data['university_ids'] =   I('post.university_ids');
        $data['subject_id']     =   I('post.subject_id');
        $data['experience_id']  =   I('post.experience_id');
        $data['background_id']  =   I('post.background_id');
        $data['TOEFL']          =   I('post.TOEFL');
        $data['IELTS']          =   I('post.IELTS');
        $data['GRE']            =   I('post.GRE');
        $data['GMAT']           =   I('post.GMAT');
        $data['GPA']            =   I('post.GPA');


        if(!$db->where("user_id=$user_id")->save($data))
            $this->ajaxReturn (msg('更新用户信息时发生错误'));

        $this->ajaxReturn(msg(''));
    }

    //register as new user by email
    public function register(){

        //user model instance
        $db =   M('user');

        $data = array(
            'email'=>I('post.email'),
            'nick_name'=>I('post.nick_name'),
            'sex'=>I('post.sex'),
            'home_town'=>I('post.home_town')
        );

        //first whether email has been used
        $result =   M('user')->where(array('email'=>$data['email']))->find();

        //if exists
        if($result){
            $this->ajaxReturn(msg('邮箱已经被注册，如果不记得密码，请申请忘记密码'));
        }

        //create a password for user
        $password='';
        //here change the token to generate 6 random integer for the password
        for ($i=0; $i<8; $i++)
            $password.=$i;
            //$password.=mt_rand(0,9);

        //send password to user based on email mail(email) //not work locally

        $data['password'] = md5($password);

        //add as new user
        if(!M('user')->add($data))
                $this->ajaxReturn (msg ('用户注册失败，请重试'));

        //return user id as result in JSON
        $this->ajaxReturn(msg(''));

    }


    //login by email
    public function emailLogin(){

        //user model instance
        $db =   M('user');

        //get fields
        $data['email']  =   I('post.email');
        $data['password']   =   I('post.password', '', 'md5');

        //print_r($data);
        //get user id if has user name, password correct
        $user_id =   $db ->where($data)->getField('user_id');

        //if not match
        if(empty($user_id)) $this->ajaxReturn (msg ('邮箱或密码错误'));

        //put user id into array
        $result['user_id']    =   $user_id;

        //need to add session

        //return result as JSON
        $this->ajaxReturn(array($result));

    }

    //login by wechat
    public function wechatLogin(){

        //user model instance
        $db =   M('user');

        //get fields
        $data = array(
            'wechat_id'=>I('post.wechat_id'),
            'nick_name'=>I('post.nick_name'),
            'home_town'=>I('post.home_town'),
            'sex'=>I('post.sex')
        );

        //if registered before
        if($user=$db->where(array('wechat_id'=>$data['wechat_id']))->find())
        {
            $result['user_id']  =   $user['user_id'];
        }
        //if not registeed
        else
        {
            //if register as new user successful
            if($user_id = $db->save($data)) $result['user_id']  =   $user_id;
            //if register fail
            else $this->ajaxReturn (msg('微信新用户注册不成功，请检察'));
        }

        //return result as JSON
        $this->ajaxReturn(array($result));

    }

    //request to reset user password when user forget
    public function passwordforget(){

        //get email
        $email  =   I('post.email');

        //check whether exists
        if(!M('user')->where(array('email'=>$email))->find())
            $this->ajaxReturn(msg('注册邮箱不存在，请检查'));

        //create a password for user
        $password='';
        //here change the token to generate 6 random integer for the password
        for ($i=0; $i<8; $i++)
            $password.=$i;

        //send password to email account
        $data = array('password'=>md5($password));

        if(!M('user')->where(array('email'=>$email))->save($data))
            $this->ajaxReturn(msg('系统更新密码失败，请重试'));

        $this->ajaxReturn(msg(''));

    }

    //user request to reset password
    public function passwordreset(){

        //get user id
        $user_id    =   I('param.2');

        //get old password
        $password_old   =   I('post.password_old', '', 'md5');
        $password_new   =   I('post.password_new', '', 'md5');

        if(!isset($password_old) || !isset($password_new))
            $this->ajaxReturn(msg('没有提供密码'));

        if($password_old!=M('user')->where("user_id=$user_id ")->getField('password'))
            $this->ajaxReturn(msg('原密码输入不正确，修改密码不成功'));

        //get password
        $data = array('password'=>$password_new);

        if(!M('user')->where("user_id=$user_id")->save($data))
            $this->ajaxReturn(msg('用户密码修改失败，请重试'));

        $this->ajaxReturn(msg(''));
    }


    //get user rank by major
    public function rankByMajor(){

        $db    =   M('user');

        $user_id    =   I('param.2');   //user
        $major_id   =   I('param.3');   //major

        //get user info
        $user_info  =   $db ->field('TOEFL, IELTS, GRE, GMAT, GPA, experience_id')
                            ->where("user_id=$user_id")
                            ->find();

        //extract
        extract($user_info);

        //get corresponding experience value
        $experience_value   =   M('experience')->where("experience_id=$experience_id")->getField('value');

        //get all data list
        $TOEFL_list =   $this->getRankListByMajor('TOEFL', $TOEFL, $major_id);
        $IELTS_list =   $this->getRankListByMajor('IELTS', $IELTS, $major_id, 1);
        $GRE_list =   $this->getRankListByMajor('GRE', $GRE, $major_id);
        $GMAT_list =   $this->getRankListByMajor('GMAT', $GMAT, $major_id);
        $GPA_list =   $this->getRankListByMajor('GPA', $GPA, $major_id, 2);
        $experience_list =   $this->getExperienceRankListByMajor($experience_value, $major_id);
        $background_list    =   $this->getBackgroundListByMajor($major_id);

        $user_count =   M('follow')->where("major_id=$major_id")->count();

        //encapsulate to a new data form
        $data   =   array(  'TOEFL'=>$TOEFL_list,
                            'IELTS'=>$IELTS_list,
                            'GRE'=>$GRE_list,
                            'GMAT'=>$GMAT_list,
                            'GPA'=>$GPA_list,
                            'experience'=>$experience_list,
                            'background'=>$background_list,
                            'users'=>$user_count);

        //return data as JSON
        $this->ajaxReturn(array($data));
    }

    //get user rank by other users
    public function rankByUser(){

        //user model instance
        $db    =   M('user');

        //get user id
        $user_id    =   I('param.2');

        //get user info
        $user_info  =   $db ->field('TOEFL, IELTS, GRE, GMAT, GPA, experience_id, subject_id, country_id')
                            ->where("user_id=$user_id")
                            ->find();

        //extract
        extract($user_info);

        //get corresponding experience value
        $experience_value   =   M('experience')->where("experience_id=$experience_id")->getField('value');

        //get all data list
        $TOEFL_list =   $this->getRankListByUser('TOEFL', $TOEFL, $subject_id, $country_id);
        $IELTS_list =   $this->getRankListByUser('IELTS', $IELTS, $subject_id, $country_id, 1);
        $GRE_list =   $this->getRankListByUser('GRE', $GRE, $subject_id, $country_id);
        $GMAT_list =   $this->getRankListByUser('GMAT', $GMAT, $subject_id, $country_id);
        $GPA_list =   $this->getRankListByUser('GPA', $GPA, $subject_id, $country_id, 2);
        $experience_list =   $this->getExperienceRankListByUser($experience_value, $subject_id, $country_id);
        $background_list    =   $this->getBackgroundListByUser($subject_id, $country_id);

        $user_count =   M('user')->where("subject_id=$subject_id")->count();

        //encapsulate to a new data form
        $data   =   array(  'TOEFL'=>$TOEFL_list,
                            'IELTS'=>$IELTS_list,
                            'GRE'=>$GRE_list,
                            'GMAT'=>$GMAT_list,
                            'GPA'=>$GPA_list,
                            'experience'=>$experience_list,
                            'background'=>$background_list,
                            'users'=>$user_count);

        //return data as JSON
        $this->ajaxReturn(array($data));


    }

    //bound email account
    public function emailBound(){

        //user model instance
        $db =   M('user');

        //get user id
        $user_id            =   I('user_id');
        //get field
        $data['email']      =   I('email');
        $data['password']   =   I('password', '', 'md5');

        //check whether email has been bound before
        // $email  =   $db->where(array('email'=>$data['email']))->find();
        // if($email)  $this->ajaxReturn (msg('此邮箱已经绑定过了，请尝试换一个邮箱'));

        $email  =   I('email');

        //create a 6 digits token
        $token='';
        //here change the token to generate 6 random integer for the password
        for ($i=0; $i<6; $i++)
            $token.=mt_rand(0,9);

        //create exp time
        $token_exp  =   time()+60*60*24;

        //set token and token_exp to data
        $data['token']  =   $token;
        $data['token_exp']  =   $token_exp;

        //check whether already get password
        $password =   $db->where("user_id=$user_id")->getField('password');

        //if already has password then no need to update password any more
        if(!empty($password))
            //get rid of password from list
            unset ($data['password']);

        //first send verify mail to user
        if(!sendMail($email, C('MAIL_BOUND_TITLE'), getMailContent($email, $token)))
            $this->ajaxReturn(msg("通过电子邮件发送验证码不成功，情重试"));

        //update user data
        if(!($result=$db->where("user_id=$user_id")->save($data)))
            $this->ajaxReturn (msg("绑定邮箱错误"));

        //return result as JSON
        $this->ajaxReturn(msg('验证码发送成功, 请尽快认证', '1', C('SUCCESS')));

    }



    //get rank list by major
    private function getRankListByMajor($field, $value, $major_id, $digit=0){

        //user model instance
        $db    =   M('user');

        //get TOEFL list
        $list =   $db->table(array('zebra_user'=>'user', 'zebra_follow'=>'follow'))
                                ->field("round(avg($field), $digit) as avg, min($field) as min, max($field) as max, count($field) as count")
                                ->where("user.user_id=follow.user_id "
                                        . "AND follow.major_id=$major_id "
                                        . "AND $field>0")
                                ->find();


        $list['rank']    =   $db->table(array('zebra_user'=>'user', 'zebra_follow'=>'follow'))
                                            ->where("user.user_id=follow.user_id "
                                                    . "AND follow.major_id=$major_id "
                                                    . "AND $field>=$value")
                                            ->getField("count($field)");
        //rank ++ to get real rank
        $list['rank']++;
        //get user personal value
        $list['user']   =   $value;

        return $list;
    }

    //get rank list
    private function getRankListByUser($field, $value, $subject_id, $country_id, $digit=0){

        //user model instance
        $db    =   M('user');

        //get TOEFL list
        $list =   $db   ->field("round(avg($field),$digit) as avg, min($field) as min, max($field) as max, count($field) as count")
                        ->where("subject_id=$subject_id "
                                . "AND country_id=$country_id "
                                . "AND $field>0")
                        ->find();

        $list['rank']    =   $db->where("subject_id=$subject_id "
                                        . "AND country_id=$country_id "
                                        . "AND $field>=$value")
                                ->getField("count($field)");
        //rank ++ to get real rank
        $list['rank']++;
        //get user personal value
        $list['user']   =   $value;

        return $list;
    }

    //get experience rank
    private function getExperienceRankListByMajor($value, $major_id){

        //user model instance
        $db    =   M('user');

        //get TOEFL list
        $list =   $db   ->table(array('zebra_user'=>'user', 'zebra_follow'=>'follow', 'zebra_experience'=>'experience'))
                        ->field("round(avg(experience.value)) as avg, min(experience.value) as min, max(experience.value) as max, count(experience.value) as count")
                        ->where("user.user_id=follow.user_id "
                                . "AND follow.major_id=$major_id "
                                . "AND user.experience_id=experience.experience_id")
                        ->find();

        $list['rank']    =   $db->table(array('zebra_user'=>'user', 'zebra_follow'=>'follow', 'zebra_experience'=>'experience'))
                                ->where("user.user_id=follow.user_id "
                                        . "AND follow.major_id=$major_id "
                                        . "AND user.experience_id=experience.experience_id "
                                        . "AND experience.value>=$value")
                                ->count();
        //rank ++ to get real rank
        $list['rank']++;
        //get user personal value
        $list['user']   =   $value;

        return $list;

    }

    //get experience rank
    private function getExperienceRankListByUser($value, $subject_id, $country_id){

        //user model instance
        $db    =   M('user');

        //get TOEFL list
        $list =   $db   ->table(array('zebra_user'=>'user', 'zebra_experience'=>'experience'))
                        ->field("round(avg(experience.value)) as avg, min(experience.value) as min, max(experience.value) as max, count(experience.value) as count")
                        ->where("user.subject_id=$subject_id "
                                . "AND user.country_id=$country_id "
                                . "AND user.experience_id=experience.experience_id")
                        ->find();

        $list['rank']    =   $db->table(array('zebra_user'=>'user', 'zebra_experience'=>'experience'))
                                ->where("user.subject_id=$subject_id "
                                        . "AND user.country_id=$country_id "
                                        . "AND user.experience_id=experience.experience_id"
                                        . "AND experience.value>=$value")
                                ->count();
        //rank ++ to get real rank
        $list['rank']++;
        //get user personal value
        $list['user']   =   $value;

        return $list;

    }

    //get background list by major info
    private function getBackgroundListByMajor($major_id){

        //background model instance
        $background_db  =   M('background');
        $user_db    =   M('user');

        //background list
        $backgrounds =   $background_db ->field('background_id, background_name')
                                        ->order('background_id')
                                        ->select();

        //get followed users
        $users  =   $user_db->table(array('zebra_user'=>'user', 'zebra_follow'=>'follow'))
                            ->field('background_id')
                            ->where("user.user_id=follow.user_id "
                                    . "AND follow.major_id=$major_id")
                            ->select();

        //re assign the array list
        foreach($backgrounds as $background)
        {
            $background_list[$background['background_id']]  =   array(
                'background_id'=>$background['background_id'],
                'background_name'=>$background['background_name'],
                'count'=>0
            );
        }

        //background user count
        foreach($users as $user)
            $background_list[$user['background_id']]['count']++;

        //shuffle the background list
        shuffle($background_list);

        return $background_list;
    }

    //get background list by user info
    private function getBackgroundListByUser($subject_id, $country_id){

        //background model instance
        $background_db  =   M('background');
        $user_db    =   M('user');

        //background list
        $backgrounds =   $background_db ->field('background_id, background_name')
                                        ->order('background_id')
                                        ->select();

        //get followed users
        $users  =   $user_db->field('background_id')
                            ->where("subject_id=$subject_id "
                                    . "AND country_id=$country_id")
                            ->select();

        //re assign the array list
        foreach($backgrounds as $background)
        {
            $background_list[$background['background_id']]  =   array(
                'background_id'=>$background['background_id'],
                'background_name'=>$background['background_name'],
                'count'=>0
            );
        }

        //background user count
        foreach($users as $user)
            $background_list[$user['background_id']]['count']++;

        //shuffle the background list
        shuffle($background_list);

        return $background_list;
    }


}
