#! C:/Python38/python.exe
# print("Content-Type: text/html\n")

import json, duolingo

duo_user = duolingo.Duolingo('lidiaCirrone', 'hyaB_3cQN-ei')
user_info = duo_user.get_user_info()
username = user_info['username']
userid = user_info['id']

language_data = user_info['language_data']
learning_language_abbr = ''
for lang in language_data:
    learning_language_abbr = lang

language_progress = duo_user.get_language_progress(learning_language_abbr)
xp = language_data[learning_language_abbr]['points_ranking_data_dict'][str(userid)]['points_data']['total']
current_languages = duo_user.get_languages(abbreviations=True)

user_object = {
    'username': username,
    'streak': language_progress['streak'],
    'xp': xp,
    'learning_language': {
        'string': language_progress['language_string'],
        'level': language_progress['level'],
        'level_percent': language_progress['level_percent']
    },
    'current_languages': current_languages
}

print(json.dumps(user_object))