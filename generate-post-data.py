# Run this after changing any files in the /posts folder
import os, itertools, json;

post_data = []
tags_data = set()
cats_data = set()

for fname in os.listdir(os.path.join(os.getcwd(), 'posts')):
	path = os.path.join(os.getcwd(), 'posts', fname)
	if os.path.isfile(path) and os.path.splitext(fname)[1] == '.md':
		with open(path) as f:
			content = f.readlines()
			json_lines = itertools.takewhile(lambda x: x.strip() != '', content)
			json_data = json.loads(''.join(json_lines));
			json_data['id'] = os.path.splitext(fname)[0]
			tags_data |= set(json_data['tags'])
			cats_data.add(json_data['category'])
			post_data.append(json_data)

post_data = sorted(post_data, key=lambda p: p['date'], reverse=True)
tags_data = sorted(tags_data, key=unicode.lower)
cats_data = sorted(cats_data, key=unicode.lower)
data_file = '<?php\n'

data_file += '$blogData = json_decode(\''
data_file += json.dumps(post_data)
data_file += '\');\n'

data_file += '$tagData = json_decode(\''
data_file += json.dumps(list(tags_data))
data_file += '\');\n'

data_file += '$catData = json_decode(\''
data_file += json.dumps(list(cats_data))
data_file += '\');\n'

with open(os.path.join(os.getcwd(), 'php', 'BlogData.php'), "w") as blog_data_file:
    blog_data_file.write(data_file)

print 'Done.'