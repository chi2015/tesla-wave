<?php

function SaveImg2($img, $option) {
    $font="../../../lib/font/norobot_font.ttf";
    if ((!$img)or(!$img[utmpname])) {
        $err=1;
        $errinfo[] = "��� ������";
        $type = false;
    }


    if (strtolower($img[ufiletyle])=="gif") {
        $ftype = "gif";
        $f = $img[path] . $img[name].".gif";
        $b = $img[path] . $img[name_big].".gif";
        $t = $img[path] . $img[tname].".gif";
        $type = true;
    }
    elseif ((strtolower($img[ufiletyle])=="jpeg")OR(strtolower($img[ufiletyle])=="jpg")) {
        $ftype = "jpeg";
        $f = $img[path] . $img[name].".jpg";
        $b = $img[path] . $img[name_big].".jpg";
        $t = $img[path] . $img[tname].".jpg";
        $type = true;
    }
    elseif(!$err) {
        $err=1;
        $errinfo[] = "������������ ������ ����� (���������: GIF � JPEG)";
        $type = false;
    }





// ���� ���� ������ �� ��������� - �� ����� :)
    if (($img[tpath])&&($img[tw])&&($img[th])) {
        $tumb = 1; // ����� ��������: 1/0
    }


// ���� ��������
    if ($type) {
        if (move_uploaded_file($img[utmpname], $f)) {
            //----------------------------------------- ������ --------------------
            $realsize = getimagesize($f);

            // ------------------------------------------------------------ ������ �������� �������� � ����� ---------------------------------
            // ��������
            if ((($realsize[0]<=$img[w])&&($realsize[1]<=$img[h]))OR($img[realsize])) {
                $fsize=1;
                $new_w = $realsize[0];
                $new_h = $realsize[1];
            }
            else {
                // ��������� ������� ��������� ���� ��� ������ �������
                // ���� ������ ������
                if ($realsize[0]>=$realsize[1]) {
                    // ����������� ����� ������
                    $new_h =  (int)$new_h =  $realsize[1]/$realsize[0]*$img[w];
                    $new_w = (int)$new_w = $img[w];
                    // ���� ������������ ������ ������ �����������, �������������
                    if ($new_h>$img[h]) {
                        $new_w = (int)$new_w =  $realsize[0]/$realsize[1]*$img[h];
                        $new_h =  (int)$new_h =  $img[h];
                    }
                }

                if ($realsize[0]<$realsize[1]) {
                    $new_w = (int)$new_w =  $realsize[0]/$realsize[1]*$img[h];
                    $new_h =  (int)$new_h =  $img[h];
                    // ���� ������������ ������ ������ �����������, �������������
                    if ($new_w>$img[w]) {
                        $new_h =  (int)$new_h =  $realsize[1]/$realsize[0]*$img[w];
                        $new_w = (int)$new_w = $img[w];
                    }
                }



            }

            if ($tumb) {
                // �������� (���� �����)
                if (($realsize[0]<=$img[tw])&&($realsize[1]<=$img[th])) {
                    $tsize=1;
                    $new_t_w = $realsize[0];
                    $new_t_h = $realsize[1];
                }
                else {
                    // ��������� ������� ��������  ���� �������� ������ ������������ �������� ������ �������
                    // ���� ������ ������
                    if ($realsize[0]>=$realsize[1]) {
                        // ����������� ����� ������
                        $new_t_h =  (int)$new_t_h =  $realsize[1]/$realsize[0]*$img[tw];
                        $new_t_w = (int)$new_t_w = $img[tw];
                        // ���� ������������ ������ ������ �����������, �������������
                        if ($new_t_h>$img[th]) {
                            $new_t_w = (int)$new_t_w =  $realsize[0]/$realsize[1]*$img[th];
                            $new_t_h =  (int)$new_t_h =  $img[th];
                        }
                    }

                    if ($realsize[0]<$realsize[1]) {
                        $new_t_w = (int)$new_t_w =  $realsize[0]/$realsize[1]*$img[th];
                        $new_t_h =  (int)$new_t_h =  $img[th];
                        // ���� ������������ ������ ������ �����������, �������������
                        if ($new_t_w>$img[tw]) {
                            $new_t_h =  (int)$new_t_h =  $realsize[1]/$realsize[0]*$img[tw];
                            $new_t_w = (int)$new_t_w = $img[tw];
                        }
                    }

                }
            }
            else {
                //$errinfo[] = "�������� �� �����";
            }

            // � ����������� �� ���� ����� ������� img
            // GIF ======= GIF ======= GIF ======= GIF ======= GIF ======= GIF ======= GIF ======= GIF
            if ($ftype == "gif") {
                // ��������� ������
                if ($fsize==1) {
                    // ��������� �������� � ������ �� ������� :)

                    // ���� ����� ��������    ��� ������������ ����
                    if ($tumb) {

                        $src_img = @imagecreatefromgif("$f");
                        $tpcolor = imagecolorat($src_img, 0, 0);
                        $dst_imgt = imagecreate($new_t_w, $new_t_h);
                        imagepalettecopy($dst_imgt,$src_img);
                        imagecopyresized($dst_imgt,$src_img, 0, 0, 0, 0, $new_t_w, $new_t_h,imagesx($src_img),imagesy($src_img));
                        $pixel_over_black = imagecolorat($dst_imgt, 0, 0);
                        $bg = imagecolorallocate($dst_imgt, 255, 255, 255);
                        imagefilledrectangle($dst_imgt, 0, 0, $new_t_w, $new_t_h,$bg);
                        imagecopyresized($dst_imgt, $src_img, 0, 0, 0, 0, $new_t_w, $new_t_h,imagesx($src_img),imagesy($src_img));
                        imagegif($dst_imgt, "$t");
                        @chmod("$t", 0644);
                        imagedestroy ($src_img);
                        imagedestroy ($dst_imgt);
                    }
                }
                else {
                    //���������
                    // ������������� � ������
                    $src_img = imagecreatefromgif("$f");

                    // �������� �������� ��������

                    if ($option['image_save_source'] == 1) {
                        $src_img1 = imagecreatefromgif("$f");
                        $dst_img1 = WatermarkFactory($src_img1, $option, 3);
                        imagegif($dst_img1, "$b");
                        @chmod("$b", 0644);
                        imagedestroy ($src_img1);

                    }

                    $dst_img =imagecreatetruecolor($new_w,$new_h);
                    imagecolortransparent($dst_img);
                    imagecopyresampled($dst_img,$src_img,0,0,0,0,$new_w,$new_h,imagesx($src_img),imagesy($src_img));

                    $dst_img = WatermarkFactory($dst_img, $option, 1);

                    if ($tumb) {
                        $dst_imgt = imagecreatetruecolor($new_t_w,$new_t_h);
                        imagecopyresampled($dst_imgt,$src_img,0,0,0,0,$new_t_w,$new_t_h,imagesx($src_img),imagesy($src_img));
                        $dst_imgt = WatermarkFactory($dst_imgt, $option, 2);
                        imagegif($dst_imgt, "$t",$img[tq]);
                        imagedestroy ($dst_imgt);
                    }

                    imagegif($dst_img, "$f");
                    @chmod("$f", 0644);
                    imagedestroy ($src_img);
                    imagedestroy ($dst_img);
                }

            }
            // JPEG ======= JPEG ======= JPEG ======= JPEG ======= JPEG ======= JPEG ======= JPEG ======= JPEG
            if ($ftype == "jpeg") {

                $src_img = imagecreatefromjpeg("$f");

                // �������� �������� ��������

                if ($option['image_save_source'] == 1) {
                    $src_img1 = imagecreatefromjpeg("$f");
                    $dst_img1 = WatermarkFactory($src_img1, $option, 3);
                    imagejpeg($dst_img1, "$b",100);
                    @chmod("$b", 0644);
                    imagedestroy ($src_img1);
                }

                $dst_img = imagecreatetruecolor($new_w,$new_h);

                imagecopyresampled($dst_img,$src_img,0,0,0,0,$new_w,$new_h,imagesx($src_img),imagesy($src_img));


                $dst_img = WatermarkFactory($dst_img, $option, 1);

                imagejpeg($dst_img, "$f",$img[q]);
                @chmod("$f", 0644);
                if ($tumb) {
                    $dst_imgt = imagecreatetruecolor($new_t_w,$new_t_h);
                    imagecopyresampled($dst_imgt,$src_img,0,0,0,0,$new_t_w,$new_t_h,imagesx($src_img),imagesy($src_img));

                    $dst_imgt = WatermarkFactory($dst_imgt, $option, 2);

                    imagejpeg($dst_imgt, "$t",$img[tq]);
                    imagedestroy ($dst_imgt);
                }
                imagedestroy ($src_img);
                imagedestroy ($dst_img);
            }

// �� ������ ����� ����� ��������� ������ ��������� ������, �� ������ �� �������?

            $fsize = filesize($f);
            if ($fsize>$img[maxsize]) {
                @unlink($f);
                @unlink($t);
                $err=1;
                $errinfo[] = "������ ����� ��������� ����������";

            }


            //----------------------------------------- ������ --------------------

        } else
        // ���� ���� �� UPLOAD
        {
            unlink($img[utmpname]);
            $err=1;
            $errinfo[] = "������ �������";
        }
    }

// �������� ������ �� �����
    $out[err] = $errinfo;
    $out[filename] = $img[name].".".$ftype;
    $out[fullfile] =$f;
    $out[fulltumb] =$t;
    $out[type] = $ftype;
    $out[fsize] = $fsize;
    $out[w] = $new_w;
    $out[h] = $new_h;


    return ($out);
}

?>
