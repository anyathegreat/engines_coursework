<?php
function getEngineName($id, $arr)
{
  foreach ($arr as $el) {
    if ($el["ID"] == $id)
      return $el["name"];
  }

  return null;
}