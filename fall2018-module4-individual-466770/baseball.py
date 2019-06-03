# -*- coding: utf-8 -*-
"""
@author: houlan
@studentID:466770
This is an individual assignment for module 4
to read box scores from a file and 
computes the Cardinals' players' batting averages in a particular season.
"""

# load packages
import re
import io
import sys, os
import pandas as pd



df = pd.DataFrame(columns=["first_name","last_name","battle_times","hit_times","run_times"])
i = 0


if len(sys.argv) < 2:
    sys.exit(f"Usage: {sys.argv[0]} filename")

filename = sys.argv[1]

if not os.path.exists(filename):
    sys.exit(f"Error: File '{sys.argv[1]}' not found")

with open(filename) as f:
    for line in f:
        m = re.match(r"(?P<first_name>\w+) (?P<last_name>\w+) (?P<battle_times>batted(.*?)times) (?P<hit_times>(.*?)hits)(?P<run_times>(.*?)runs)", line.strip())
        if m is not None:
            d = m.groupdict()
            d['battle_times'] = re.search(r"\d",d['battle_times']).group()
            d['hit_times'] = re.search(r"\d",d['hit_times']).group()
            d['run_times'] = re.search(r"\d",d['run_times']).group()
            df.loc[i] = d
            i+=1 
            
df["full_name"] = df.first_name+" "+df.last_name
grouped = df.groupby("full_name").apply(lambda l: round(l.hit_times.astype(int).sum()/l.battle_times.astype(int).sum(),3)).sort_values(ascending=False)

for name in grouped.index:
    print("%s:%.3f"%(name,grouped[name]))
    