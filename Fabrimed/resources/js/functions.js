var hexcase = 0;
var b64pad = "";

function encrypt(input)
{
  try {
    b64pad;
  } catch (e) {
    b64pad = '';
  }//fin del try catch

  var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
  var output = "";
  var len = input.length;

  for (var i = 0; i < len; i += 3)
  {
    var triplet = (input.charCodeAt(i) << 16) | (i + 1 < len ? input.charCodeAt(i + 1) << 8 : 0) | (i + 2 < len ? input.charCodeAt(i + 2) : 0);
    for (var j = 0; j < 4; j++)
    {
      if (i * 8 + j * 6 > input.length * 8) {
        output += b64pad;
      } else {
        output += tab.charAt((triplet >>> 6 * (3 - j)) & 0x3F);
      }
    }//fin del for 1
  }//fin del for2;
  return output;
}//fin del la function encpwd


