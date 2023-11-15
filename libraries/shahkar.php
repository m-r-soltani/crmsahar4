<?php
class Shahkar
{

//VOIP OPERATION
    public function putOperationVoipRealIrani($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::putVoipRealIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->putOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function updateOperationVoipRealIrani($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::updateVoipRealIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function transferOperationVoipRealIrani($method,$userinfo,$factor_id)
    {
        $url = "rest/shahkar/update";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::transferVoipRealIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function putOperationVoipRealKhareji($method,$userinfo,$factor_id)
    {

        $url = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::putVoipRealKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->putOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function updateOperationVoipRealKhareji($method,$userinfo,$factor_id)
    {
        $url = "rest/shahkar/update";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::updateVoipRealKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function transferOperationVoipRealKhareji($method,$userinfo,$factor_id)
    {
        $url = "rest/shahkar/update";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::transferVoipRealKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function putOperationVoipLegalIrani($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::putVoipLegalIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->putOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function updateOperationVoipLegalIrani($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::updateVoipLegalIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function transferOperationVoipLegalIrani($method,$userinfo,$factor_id)
    {
        $url = "rest/shahkar/update";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::transferVoipLegalIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function putOperationVoipLegalKhareji($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::putVoipLegalKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->putOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function updateOperationVoipLegalKhareji($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::updateVoipLegalKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function transferOperationVoipLegalKhareji($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::transferVoipLegalKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function closeOperationVoip($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::closeVoipServices($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function deleteOperationVoip($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::deleteVoipServices($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }
//END VOIP

//ADSL OPERATION
    public function putOperationAdslRealIrani($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::putAdslRealIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->putOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function updateOperationAdslRealIrani($method,$userinfo,$factor_id)
    {
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $url = "http://localhost/saharert/api.php";
            $data = ShahkarHelper::updateAdslRealIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function transferOperationAdslRealIrani($method,$userinfo,$factor_id)
    {
        $url = "rest/shahkar/update";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::transferAdslRealIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function putOperationAdslRealKhareji($method,$userinfo,$factor_id)
    {
        $url = "rest/shahkar/put";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::putAdslRealKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->putOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        } else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function updateOperationAdslRealKhareji($method,$userinfo,$factor_id)
    {
        $url = "rest/shahkar/update";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::updateAdslRealKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function transferOperationAdslRealKhareji($method,$userinfo,$factor_id)
    {
        $url = "rest/shahkar/update";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::transferAdslRealKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function putOperationAdslLegalIrani($method,$userinfo,$factor_id)
    {
        $url = "rest/shahkar/put";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::putAdslLegalIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->putOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function updateOperationAdslLegalIrani($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
//      $url = "rest/shahkar/update";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::updateAdslLegalIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function transferOperationAdslLegalIrani($method,$userinfo,$factor_id)
    {
        $url = "rest/shahkar/update";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::transferVoipLegalIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function putOperationAdslLegalKhareji($method,$userinfo,$factor_id)
    {
        $url = "rest/shahkar/put";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::putAdslLegalKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->putOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function updateOperationAdslLegalKhareji($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
//      $url = "rest/shahkar/update";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::updateAdslLegalKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function transferOperationAdslLegalKhareji($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
//      $url = "rest/shahkar/update";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::transferAdslLegalKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function closeOperationAdsl($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
//      $url = "rest/shahkar/update";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::closeAdslServices($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function deleteOperationAdsl($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
//      $url = "rest/shahkar/delete";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::deleteAdsl($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }
//END ADSL


//wireless OPERATION
    public function putOperationWirelessRealIrani($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
//      $url = "rest/shahkar/put";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::putWirelessRealIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->putOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function updateOperationWirelessRealIrani($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
//      $url = "rest/shahkar/update";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $url = "http://localhost/saharert/api.php";
            $data = ShahkarHelper::updateWirelessRealIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function transferOperationWirelessRealIrani($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
//      $url = "rest/shahkar/put";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::transferWirelessRealIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function putOperationWirelessRealKhareji($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
//      $url = "rest/shahkar/put";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::putWirelessRealKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->putOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function updateOperationWirelessRealKhareji($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
//      $url = "rest/shahkar/update";
//      $userinfo['clase']=response
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::updateWirelessRealKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function transferOperationWirelessRealKhareji($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
//      $url = "rest/shahkar/put";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::transferWirelessRealKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function putOperationWirelessLegalIrani($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
//      $url = "rest/shahkar/put";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::putWirelessLegalIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->putOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function updateOperationWirelessLegalIrani($method,$userinfo,$factor_id)
    {
        $url = "rest/shahkar/update";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::updateWirelessLegalIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function transferOperationWirelessLegalIrani($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
//      $url = "rest/shahkar/put";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::transferWirelessLegalIrani($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function putOperationWirelessWirelessLegalKhareji($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
//      $url = "rest/shahkar/put";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::putWirelessLegalKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->putOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function updateOperationWirelessLegalKhareji($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
//      $url = "rest/shahkar/update";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::updateWirelessLegalKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function transferOperationWirelessLegalKhareji($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
//      $url = "rest/shahkar/put";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::transferWirelessLegalKhareji($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function closeOperationWireless($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
//      $url = "rest/shahkar/update";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::closeWirelessServices($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function deleteOperationWireless($method,$userinfo,$factor_id)
    {
        $url = "http://localhost/saharert/api.php";
        //      $url = "rest/shahkar/delete";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $data = ShahkarHelper::deleteWirelessServices($userinfo, $request_id);
            if ($data) {
                $result = $this->shahkarOperation($method, $data, $factor_id, $url, $userinfo);
                if ($result) {
                    return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }
//END wireless





//estelaam haye shahkar
    public function estSehatSalamat($method, $url, $username, $password)
    {
        $data = [];
        $res  = Helper::Simple_Rest($method, $data, $url);
        return $res;
    }

    public function estRequestHistory($method, $factor_id,$branch_id, $enquiry_id)
    {
        $url = "http://localhost/saharert/api.php";
        $userinfo = ShahkarHelper::stelamUserInfo($factor_id, $branch_id);
        if ($userinfo) {
            $request_id = $this->makeRequestId($this->userServerId);
            if ($request_id) {
                $data = ShahkarHelper::DataEstRequestHistory($request_id, $enquiry_id);//enquiryId bayad tabdil be $enquiry_id beshe
                if ($data) {
                    $result = $this->estelamOperation($method, $data, $factor_id, $url, $userinfo);
                    if ($result) {
                        return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                    } else {
                        return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                    }
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        } else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }


    public function estDailyReport($method, $factor_id,$branch_id)
    {
        $userinfo = ShahkarHelper::stelamUserInfo($factor_id, $branch_id);
        if ($userinfo) {
        //          $url       = "rest/shahkar/report";
            $url = "http://localhost/saharert/api.php";
            $request_id = $this->makeRequestId($this->userServerId);
            if ($request_id) {
                $data = ShahkarHelper::DataEstestDailyReport($request_id);
                if ($data) {
                    $result = $this->estelamOperation($method, $data, $factor_id, $url, $userinfo);
                    if ($result) {
                        return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                    } else {
                        return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                    }
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        } else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function estServiceStatus($method, $factor_id,$branch_id)
    {
        //      $url  = "rest/shahkar/provider-enquiry";
        $url = "http://localhost/saharert/api.php";
        $userinfo = ShahkarHelper::stelamUserInfo($factor_id, $branch_id);
        if ($userinfo) {
            $request_id = $this->makeRequestId($this->userServerId);
            if ($request_id) {
                $data = ShahkarHelper::DataEstServiceStatus($request_id, $userinfo);
                if ($data) {
                    $result = $this->estelamOperation($method, $data, $factor_id, $url, $userinfo);
                    if ($result) {
                        return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                    } else {
                        return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                    }
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false);
                }
            } else {
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        } else {
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    public function estReceiveClassifier($method,$factor_id,$branch_id)
    {
        //      $url  = "rest/shahkar/classifier-enquiry";
        $url  = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id){
            $userinfo  = ShahkarHelper::stelamUserInfo($factor_id, $branch_id);
            if ($userinfo){
                $data = ShahkarHelper::DataEstReceiveClassifier($request_id,$userinfo);
                if ($data){
                    $result = $this->estelamOperation($method, $data, $factor_id, $url,$userinfo);
                    if ($result) {
                        return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                    } else {
                        return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                    }
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false);
                }
            }else{
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else{
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    //mokhtas be service dahandegan mobile ast
    public function estServiceMatching($method,$factor_id,$branch_id)
    {
        //      $url  = "rest/shahkar/serviceID-matching";
        $url  = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id){
            $userinfo  = ShahkarHelper::stelamUserInfo($factor_id, $branch_id);
            if ($userinfo){
                $data = ShahkarHelper::DataEstServiceMatching($request_id,$userinfo);
                if ($data){
                    $result = $this->estelamOperation($method, $data, $factor_id, $url,$userinfo);
                    if ($result) {
                        return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                    } else {
                        return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                    }
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false);
                }
            }else{
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else{
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    //mokhtas be service dahandegan mobile ast
    public function estServiceMatching2($method,$factor_id,$branch_id)
    {
        //      $url  = "rest/shahkar/serviceID-matching-2";
        $url = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id) {
            $userinfo = ShahkarHelper::stelamUserInfo($factor_id, $branch_id);
            if ($userinfo) {
                $data = ShahkarHelper::DataEstServiceMatching2($request_id, $userinfo);
                if ($data) {
                    $result = $this->estelamOperation($method, $data, $factor_id, $url, $userinfo);
                    if ($result) {
                        return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                    } else {
                        return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                    }
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false);
                }
            }else{
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else{
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }

    //mokhtas be service dahandegan mobile ast
    public function estServiceMatching3($method,$factor_id,$branch_id)
    {
        //      $url  = "rest/shahkar/serviceID-matching3";
        $url  = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id){
            $userinfo  = ShahkarHelper::stelamUserInfo($factor_id, $branch_id);
            if ($userinfo){
                $data = ShahkarHelper::DataEstServiceMatching3($request_id,$userinfo);
                if ($data){
                    $result = $this->estelamOperation($method, $data, $factor_id, $url,$userinfo);
                    if ($result) {
                        return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                    } else {
                        return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                    }
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false);
                }
            }else{
                return array('Error' => false, 'hasshahkarlog_id' => false);
            }
        }else{
            return array('Error' => false, 'hasshahkarlog_id' => false);
        }

    }

    public function estReportOfOperatorsServices($method,$factor_id,$branch_id)
    {
        //      $url  = "rest/shahkar/providers_summary";
        $url  = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id){
            $userinfo  = ShahkarHelper::stelamUserInfo($factor_id, $branch_id);
            if ($userinfo){
                $data = ShahkarHelper::DataEstReportOfOperatorsServices($request_id);
                if ($data){
                    $result = $this->estelamOperation($method, $data, $factor_id, $url,$userinfo);
                    if ($result) {
                        return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                    } else {
                        return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                    }
                } else {
                    return array('Error' => false, 'hasshahkarlog_id' => false);
                }
            }else{
                return  array('Error' => false, 'hasshahkarLog_id' => false);
            }
        }else{
            return  array('Error' => false, 'hasshahkarlog_id' => false);
        }
    }
	
	public function makeRequestId($providercode)
    {
        $date       = DateTime::createFromFormat('U.u', microtime(TRUE));
        $date->setTimeZone(new DateTimeZone('Asia/Tehran'));
        $resultdate = $date->format('YmdHisu');
        $request_id = $providercode . $resultdate;
        if ($request_id) {
            return $request_id;
        }else{
			return false;
		}
    }
	
    public static function updateLogShahkar($res, $insertuser)
    {
		
		$res					= json_decode($res,true);
        $arr                    = [];
        $arr['id']              = $insertuser;
        $arr['responsecode']    = $res['response'];//fake
        $arr['jresponse']       = json_encode($res);
        $sql    = Helper::Update_Generator($arr, 'shahkar_log', "WHERE id =:id");
        $update = Db::secure_update_array($sql, $arr);
        if(!$update)
        {
            return false;
        }else{
            return $update;
        }
    }
    public function insertLogShahkar($userinfo, $method, $requestname, $factor_id=false)
    {
		$arr = [];
        if($factor_id){
            $arr['factor_id']	= $factor_id;
			$arr['emkanat_id']  = $userinfo[0]['emkanatid'];
			$arr['service_type']= $userinfo[0]['servicetype'];
        }
		$arr['tarikh']			= Helper::Today_Miladi_Date()." ".Helper::nowTimeTehran();
        $arr['subscriber_id']  	= $userinfo[0]["id"];
        $arr['request_type']   	= $method;
        $arr['requestname']   	= $requestname;
        $arr['jresponse']      	= '';
        $arr['responsecode']   	= 0;
        $sql    				= Helper::Insert_Generator($arr, 'shahkar_log');
        $insert 				= Db::secure_insert_array($sql, $arr);
        return $insert;
    }

    public function estAuthenticationIranianReal($method, $subid, $providercode, $url)
    {
        $request_id = $this->makeRequestId($providercode);
        $userinfo   = ShahkarHelper::getSubInfo($subid);
        $data       = ShahkarHelper::DataEstAuthenticationIranianReal($request_id, $userinfo);
        $insertuser = $this->insertLogShahkar($userinfo, $method, "estAuthIraniReal");
		if($insertuser){
			$res = Helper::Simple_Rest($method, $data, $url);
			if($res){
				$update = self::updateLogShahkar($res, $insertuser);
				return $insertuser;
			}else{
				return false;
			}
		}else{
			return false;
		}
        return false;
    }
	
	    public function estAuthenticationIranianLegal($method, $subid, $providercode, $url)
    {
        $request_id = $this->makeRequestId($providercode);
        $userinfo   = ShahkarHelper::getSubInfo($subid);
        $data       = ShahkarHelper::DataEstAuthenticationIranianLegal($request_id, $userinfo);
        $insertuser = $this->insertLogShahkar($userinfo, $method, "estAuthIraniLegal");
		if($insertuser){
			$res = Helper::Simple_Rest($method, $data, $url);
			if($res){
			$update = self::updateLogShahkar($res, $insertuser);
				return $res;
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
        return false;
    }

    public function estAuthenticationForeignReal($method,$factor_id,$branch_id)
    {
        //$url = "rest/shahkar/estelaam";
        $url   = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id){
            $userinfo  = ShahkarHelper::stelamUserInfo($factor_id, $branch_id);
            if ($userinfo){
                $data      = ShahkarHelper::DataEstAuthenticationForeignReal($request_id,$userinfo);
                if ($data){
                    $result = $this->estelamOperation($method, $data, $factor_id, $url,$userinfo);
                    if ($result) {
                        return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                    } else {
                        return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                    }
                } else {
                    return array('Error' => 'false','hasshahkarlog_id'=> 'false');
                }
            }else{
                return array('Error' => 'false','hasshahkarlog_id'=> 'false');
            }
        }else{
            return array('Error' => 'false','hasshahkarlog_id'=> 'false');
        }
    }

    public function estPostalCode($method,$factor_id,$branch_id)
    {
        //address sho dorost konm
        //$url = "rest/shahkar/estelaam";
        $url   = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id){
            $userinfo  = ShahkarHelper::stelamUserInfo($factor_id, $branch_id);
            if ($userinfo){
                $data      = ShahkarHelper::DataEstPostalCode($request_id,$userinfo);
                if ($data){
                    $result = $this->estelamOperation($method, $data, $factor_id, $url,$userinfo);
                    if ($result) {
                        return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                    } else {
                        return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                    }
                } else {
                    return array('Error' => 'false','hasshahkarlog_id'=> 'false');
                }
            }else{
                return array('Error' => 'false','hasshahkarlog_id'=> 'false');
            }
        }else{
            return array('Error' => 'false','hasshahkarlog_id'=> 'false');
        }

    }

    public function estServices($method,$factor_id,$branch_id)
    {
        //$url = "rest/shahkar/serviceReport";
        $url   = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id){
            $userinfo  = ShahkarHelper::stelamUserInfo($factor_id, $branch_id);
            if ($userinfo){
                $data      = ShahkarHelper::DataEstServices($request_id,$userinfo);
                if ($data){
                    $result = $this->estelamOperation($method, $data, $factor_id, $url,$userinfo);
                    if ($result) {
                        return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                    } else {
                        return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                    }
                }else{
                    return array('Error' => 'false','hasshahkarlog_id'=> 'false');
                }
            }else{
                return array('Error' => 'false','hasshahkarlog_id'=> 'false');
            }
        } else {
            return array('Error' => 'false','hasshahkarlog_id'=> 'false');
        }
    }

    public function estReceiveTrackingCode($method,$factor_id,$branch_id)
    {
        //$url = "rest/shahkar/rest/shahkar/serviceReport";
        $url   = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id){
            $userinfo  = ShahkarHelper::stelamUserInfo($factor_id, $branch_id);
            if ($userinfo){
                $data      = ShahkarHelper::DataEstReceiveTrackingCode($request_id,$userinfo);
                if ($data){
                    $result = $this->estelamOperation($method, $data, $factor_id, $url,$userinfo);
                    if ($result) {
                        return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                    } else {
                        return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                    }
                } else {
                    return array('Error' => 'false','hasshahkarlog_id'=> 'false');
                }
            }else{
                return array('Error' => 'false','hasshahkarlog_id'=> 'false');
            }
        }else{
            return array('Error' => 'false','hasshahkarlog_id'=> 'false');
        }
    }

    public function estServiceByTrackingCode($method,$factor_id,$branch_id)
    {
        //$url = "rest/shahkar/rest/shahkar/serviceReport";
        $url   = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id){
            $userinfo  = ShahkarHelper::stelamUserInfo($factor_id, $branch_id);
            if ($userinfo){
                $data      = ShahkarHelper::DataEstServiceByTrackingCode($request_id,$userinfo);
                if ($data){
                    $result = $this->estelamOperation($method, $data, $factor_id, $url,$userinfo);
                    if ($result) {
                        return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                    } else {
                        return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                    }
                } else {
                    return array('Error' => 'false','hasshahkarlog_id'=> 'false');
                }
            }else{
                return array('Error' => 'false','hasshahkarlog_id'=> 'false');
            }
        }else{
            return array('Error' => 'false','hasshahkarlog_id'=> 'false');
        }
    }

    public function estTedadSimkart($method,$factor_id,$branch_id)
    {
        //      $url   = "rest/shahkar/rest/shahkar/mobileCount";
        $url   = "http://localhost/saharert/api.php";
        $request_id = $this->makeRequestId($this->userServerId);
        if ($request_id){
            $userinfo  = ShahkarHelper::stelamUserInfo($factor_id, $branch_id);
            if ($userinfo){
                $data      = ShahkarHelper::DataEstTedadSimkart($request_id,$userinfo);
                if ($data){
                    $result = $this->estelamOperation($method, $data, $factor_id, $url,$userinfo);
                    if ($result) {
                        return array('Error' => true, 'hasshahkarlog_id' => true, 'shahkarlog_id' => $result[1]);
                    } else {
                        return array('Error' => false, 'hasshahkarlog_id' => false, 'shahkarlog_id' => $result[1]);
                    }
                } else {
                    return array('Error' => 'false','hasshahkarlog_id'=> 'false');
                }
            }else{
                return array('Error' => 'false','hasshahkarlog_id'=> 'false');
            }
        }else{
            return array('Error' => 'false','hasshahkarlog_id'=> 'false');
        }

    }

    public function shahkarOperation($method,$data, $factor_id,$url,$userinfo)
    {
        $insertuser = $this->insertLogShahkar($userinfo,$method, $factor_id);//id rows shahkarlog
        if($insertuser){
            $res    = Helper::Simple_Rest($method, $data,$url);
            if($res){
                self::updateLogShahkar($res,$insertuser);
                return array($res, $insertuser);
            }
        }else{
            return false;
        }
        return $res;
    }

    public function putOperation($method,$data, $factor_id,$url,$userinfo)
    {
        $insertuser = $this->insertLogShahkar($userinfo,$method, $factor_id);//id rows shahkarlog
        if($insertuser){
            $res    = Helper::Simple_Rest($method, $data,$url);
            if($res){
                self::updateLogShahkar($res,$insertuser);
                return array($res,$insertuser);
            }
        }else{
            return false;
        }
        return $res;
    }

    public function estelamOperation($method,$data, $factor_id,$url,$userinfo)
    {
        $insertuser = $this->insertLogShahkar($userinfo,$method, $factor_id);//id rows shahkarlog
        if($insertuser){
            $res    = Helper::Simple_Rest($method, $data,$url);
            if($res){
                self::updateLogShahkar($res,$insertuser);
                return array($res, $insertuser);
            }
        }else{
            return false;
        }
        return $res;
    }

}
