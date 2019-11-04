#!/bin/bash
url=$1
protocol=${url//:*/}
machine=${url//*:\/\//}
machine=${machine%/}
/usr/bin/gnome-terminal -e "$protocol $machine"
