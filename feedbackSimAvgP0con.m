%% Simulate average pCon0 in feedback sess 2 (last imp. trials) and sess 3 
%% (all imp. trials) in each time-group, for each task:

load('behavioralData.mat');

dataNames = {'stability', 'feedback'};
taskNames = {'Vertical','Horizontal'};
dataTimeGroupNames.feedback = {'day','month'};
dataTimeGroupNames.stability = {'hour','day','week','month','months3',...
    'months8','years'};
timeNames = dataTimeGroupNames.feedback;

nSims = 1e5;
simNunVect = (0:nSims)';

S = RandStream('mlfg6331_64'); % random number stream (for reproducibility)


T = table(simNunVect,'VariableNames',{'simNum'});

for task = 1:2
    taskName = taskNames{task};
    for ti = 1:length(timeNames)
        timeName = timeNames{ti};
        for s = 2:3
            if s == 2
                pConSess = mean( behav.feedback.(taskName).(timeName...
                    ).(['sess' num2str(s)]).dev0.responseCongruent.mat(:,...
                    21:40), 2 );
            elseif s == 3
                pConSess = behav.feedback.(taskName).(timeName...
                    ).(['sess' num2str(s)]).dev0.responseCongruent.mean;
            end
            colName = ['pCon0Avg_'  taskName(1:3), '_' timeName ...
                '_sess_' num2str(s)];
            realAvg_pCon = mean(pConSess);
            
            nSample = length(pConSess);
            simAvg_pCon = nan(nSims,1);

            for ss = 1:nSims
                pConSess_sim = datasample( S, pConSess, nSample );
                simAvg_pCon(ss) = mean( pConSess_sim );
            end

            addCol = [realAvg_pCon; simAvg_pCon];

            T = addvars( T, addCol, 'NewVariableNames', {colName} );

        end
    end
end

writetable( T, 'feedbackSimAvgP0con.csv' );



%% Simulate average pCon0 similarly, but with 

load('behavioralData.mat');

dataNames = {'stability', 'feedback'};
taskNames = {'Vertical','Horizontal'};
dataTimeGroupNames.feedback = {'day','month'};
dataTimeGroupNames.stability = {'hour','day','week','month','months3',...
    'months8','years'};
timeNames = dataTimeGroupNames.feedback;

nSims = 1e5;
simNunVect = (0:nSims)';

S = RandStream('mlfg6331_64'); % random number stream (for reproducibility)


T = table(simNunVect,'VariableNames',{'simNum'});

for task = 1:2
    taskName = taskNames{task};
    for ti = 1:length(timeNames)
        timeName = timeNames{ti};
        pConSess_2 = mean( behav.feedback.(taskName).(timeName...
            ).sess2.dev0.responseCongruent.mat(:,...
            21:40), 2 );
        pConSess_3 = behav.feedback.(taskName).(timeName...
            ).sess3.dev0.responseCongruent.mean;
        colName2 = ['pCon0Avg_'  taskName(1:3), '_' timeName  '_sess_2'];
        colName3 = ['pCon0Avg_'  taskName(1:3), '_' timeName '_sess_3'];
        realAvg_pCon_2 = mean(pConSess_2);
        realAvg_pCon_3 = mean(pConSess_3);
            
        nSample = length(pConSess_2);
        
        simAvg_pCon_2 = nan(nSims,1);
        simAvg_pCon_3 = nan(nSims,1);

        for ss = 1:nSims
            simLocs = datasample( S, 1:nSample, nSample );
            pConSess_sim_2 = pConSess_2(simLocs);
            pConSess_sim_3 = pConSess_3(simLocs);
            
            simAvg_pCon_2(ss) = mean( pConSess_sim_2 );
            simAvg_pCon_3(ss) = mean( pConSess_sim_3 );
        end

        addCol2 = [realAvg_pCon_2; simAvg_pCon_2];
        addCol3 = [realAvg_pCon_3; simAvg_pCon_3];

        T = addvars( T, addCol2, 'NewVariableNames', {colName2} );
        T = addvars( T, addCol3, 'NewVariableNames', {colName3} );

    end
end

writetable( T, 'feedbackSimAvgP0con_GROUP.csv' );
save( 'feedbackSimAvgP0con_GROUP.mat', 'T', 'behav' );



