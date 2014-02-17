echo "Starting..."
for i in {1..1000}
do
	curl "http://s-oke.com/beta/launcher.htm" 
	sleep 1
	echo "$i";
done
echo "Done."
